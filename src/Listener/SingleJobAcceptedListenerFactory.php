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
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for \Gastro24\Listener\SingleJobAcceptedListener
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test  
 */
class SingleJobAcceptedListenerFactory implements FactoryInterface
{
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $orders  = $container->get('repositories')->get('Orders');
        $mailer  = $container->get('Core/MailService');
        $service = new SingleJobAcceptedListener($orders, $mailer);
        
        return $service;    
    }
}
