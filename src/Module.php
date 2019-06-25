<?php

namespace JobsFrankfurt;

use Yawik\Composer\AssetProviderInterface;
use Core\ModuleManager\ModuleConfigLoader;
use JobsFrankfurt\Options\Landingpages;
use Zend\Console\Console;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\Parameters;

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
            'Zend\Loader\StandardAutoloader' => array(
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

                if ('lang/jobboard' == $matchedRouteName || 'lang' == $matchedRouteName)  {
                    $query = $event->getRequest()->getQuery();
                    $query->set('l','{"postalCode":"60386","city":"Frankfurt am Main","street":"Fechenheimer Leinpfad","region":"Hesse","country":"Germany","osm_key":"club","osm_value":"sport","coordinates":{"type":"Point","coordinates":[8.7740561,50.1206359]}}');
                    $query->set('d','20');

                }

                if ('lang/landingPage' == $matchedRouteName) {
                    $services = $event->getApplication()->getServiceManager();
                    $options = $services->get(Landingpages::class);
                    $term = $routeMatch->getParam('q');

                    if (!$term) {
                        return;
                    }

                        $query = $options->getQueryParameters($term);
                        $routeMatch->setParam('wpId', $options->getIdMap($term));
                        $routeMatch->setParam('isLandingPage', true);
                        $routeMatch->setParam('term', $term);

                        if ($query) {
                            $origQuery = $event->getRequest()->getQuery()->toArray();
                            if (count($origQuery)) {
                                $routeMatch->setParam('isFilteredLandingPage', true);
                                $query = array_merge($origQuery, $query);
                            }
                            $event->getRequest()->setQuery(new Parameters($query));
                        } else {
                            return;
                        }
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

                    if (!$routeMatch->getParam('isLandingPage')) {
                        $query = $query->toArray();
                        unset($query['clear']);
                        if (isset($query['q'])) {
                            $query['q'] = strtolower($query['q']);
                        }
                        $map = $options->getQueryMap();

                        foreach ($map as $term => $spec) {
                            if (isset($spec['q'])) { $spec['q'] = strtolower($spec['q']); }
                            if ($spec === $query) {
                                /* \Zend\Http\PhpEnvironment\Response $response */
                                $url = $event->getRouter()->assemble(['q' => $term, 'format' => 'html'], ['name' => 'lang/landingPage']);
                                $response = $event->getResponse();
                                $response->getHeaders()->addHeaderLine('Location', $url);
                                $response->setStatusCode(302);
                                $event->setResult($response);
                                return $response;
                            }
                        }
                    }

                }

                if ('lang/jobs/view' == $matchedRouteName) {
                    $query = $event->getRequest()->getQuery();
                    $query->set('id', $routeMatch->getParam('id') ?: $event->getRequest()->getQuery('id'));
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
