<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Listener;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for \Gastro24\Listener\UserRegisteredListener
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test  
 */
class UserRegisteredListenerFactory implements FactoryInterface
{
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var \Laminas\Http\PhpEnvironment\Request $request
         * @var \Laminas\Mvc\MvcEvent $event */
        $application = $container->get('Application');
        $request     = $application->getRequest();
        $type        = $request->getPost('pt');
        $router      = $container->get('router');
        $response    = $application->getResponse();
        $auth        = $container->get('AuthenticationService');
        $events      = $application->getEventManager();

        $service     = new UserRegisteredListener($type, $router, $response, $auth, $events);
        
        return $service;
    }
}
