<?php

namespace JobsFrankfurt;

use Yawik\Composer\AssetProviderInterface;
use Core\ModuleManager\ModuleConfigLoader;
use JobsFrankfurt\Options\Landingpages;
use Laminas\Console\Console;
use Laminas\Mvc\MvcEvent;
use Laminas\Stdlib\Parameters;

/**
 * Bootstrap class of our demo skin
 */
class Module implements AssetProviderInterface
{
    const TEXT_DOMAIN = __NAMESPACE__;

    /**
     * indicates, that the autoload configuration for this module should be loaded.
     * @see
     *
     * @var bool
     */
    public static $isLoaded=false;

    public function getPublicDir()
    {
        return __DIR__ . '/../public';
    }


    /**
     * Tells the autoloader, where to search for the JobsFrankfurt classes
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {

        return array(
            'Laminas\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../src',
                ),
            ),
        );
    }

    /**
     * Using the ModuleConfigLoader allow you to split the modules.config.php into several files.
     *
     * @return array
     */
    public function getConfig()
    {
        return ModuleConfigLoader::load(__DIR__ . '/../config');
    }

    function onBootstrap(MvcEvent $e)
    {
        self::$isLoaded=true;
        $eventManager = $e->getApplication()->getEventManager();
        $services     = $e->getApplication()->getServiceManager();

        /*
         * remove Submenu from "applications"
         */
        $config=$services->get('config');
        unset($config['navigation']['default']['apply']['pages']);
        $services->setAllowOverride(true);
        $services->setService('config', $config);
        $services->setAllowOverride(false);

        if (!Console::isConsole()) {
            $sharedManager = $eventManager->getSharedManager();

            /*
             * use a neutral layout, when rendering the application form and its result page.
             * Also the application preview should be rendered in this layout.
             *
             * We need a post dispatch hook on the controller here as we need to have
             * the application entity to determine how to set the layout in the preview page.
             */
            $listener = function ($event) {
	            $viewModel  = $event->getViewModel();
	            $template   = 'layout/application-form';
	            $controller = $event->getTarget();

	            if ($controller instanceof \Applications\Controller\ApplyController) {
		            $viewModel->setTemplate($template);
		            return;
	            }

	            if ($controller instanceof \Applications\Controller\ManageController
	                && 'detail' == $event->getRouteMatch()->getParam('action')
	                && 200 == $event->getResponse()->getStatusCode()
	            ) {
		            $result = $event->getResult();
		            if (!is_array($result)) {
			            $result = $result->getVariables();
		            }
		            if ($result['application']->isDraft()) {
			            $viewModel->setTemplate($template);
		            }
	            }

            };

            $sharedManager->attach(
                'Applications',
                MvcEvent::EVENT_DISPATCH,$listener,
                -2 /*postDispatch, but before most of the other zf2 listener*/
            );
            $sharedManager->attach(
            	'CamMediaintown',
	            MvcEvent::EVENT_DISPATCH,$listener,
	            -2);

            $eventManager->attach(MvcEvent::EVENT_ROUTE, function(MvcEvent $event) {
                $routeMatch = $event->getRouteMatch();

                if (!$routeMatch) { return; }

                $matchedRouteName = $routeMatch->getMatchedRouteName();

                if ('lang/jobs/view' == $matchedRouteName) {
                    $query = $event->getRequest()->getQuery();
                    $query->set('id', $routeMatch->getParam('id') ?: $event->getRequest()->getQuery('id'));
                }
                
                if ('lang/jobboard' == $matchedRouteName || 'lang/landingPage' == $matchedRouteName) {
                    $services = $event->getApplication()->getServiceManager();
                    $options = $services->get(Landingpages::class);
                    $query = $event->getRequest()->getQuery();

                    foreach ([
                        'r' => '__region_MultiString',
                        'l' => '__city_MultiString',
                        'c' => '__organizationTag',
                        'p' => '__profession_MultiString',
                        'i' => '__industry_MultiString',
                        't' => '__employmentType_MultiString',
                        ] as $shortName => $longName) {

                        if ($v = $query->get($shortName)) {
                            $query->set($longName, $v);
                            $query->offsetUnset($shortName);
                        }
                    }
                }
            }, -9999);

            $eventManager->attach(MvcEvent::EVENT_DISPATCH, function(MvcEvent $e) {
                $controller = $e->getTarget();
                if ( (\Auth\Controller\RegisterController::class == get_class($controller)
                      || \CompanyRegistration\Controller\RegistrationController::class == get_class($controller)
                     )
                    && (($pt = $e->getRequest()->getQuery('pt')) || ($pt = $e->getRequest()->getPost('pt')))
                ) {
                    $result = $e->getResult();
                    $form   = $result->getVariable('form');
                    $form->add([
                        'type' => 'hidden',
                        'name' => 'pt',
                        'attributes' => [ 'value' => $pt ],
                    ]);
                }
            }, -10);

            $eventManager->attach(MvcEvent::EVENT_RENDER, function(MvcEvent $e) {
                $services     = $e->getApplication()->getServiceManager();
                $navigation   = $services->get('Core/Navigation');

                $page = [
                    'label'      => 'Rechnungsanschrift',
                    'order'      => 100,
                    'resource'   => 'route/lang/settings',
                    'route'      => 'lang/settings',
                    'router'     => $e->getRouter(),
                    'action'     => 'index',
                    'controller' => 'index',
                    'params'     => ['module' => 'Orders'],
                ];
                $navigation->addPage($page);
            }, 5);
        }

    }
}
