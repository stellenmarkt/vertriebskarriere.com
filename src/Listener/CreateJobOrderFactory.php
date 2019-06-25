<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2016 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class CreateJobOrderFactory implements FactoryInterface
{
    /**
     * Create a CreateJobOrder listener
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     *
     * @return CreateJobOrder
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options         = $container->get('Orders/Options/Module');
        $providerOptions = $container->get('Jobs/Options/Provider');
        $priceFilter     = $container->get('FilterManager')->get('Jobs/ChannelPrices');
        $repositories    = $container->get('repositories');
        $repository      = $repositories->get('Orders');
        $invoice         = $container->get('Orders/Entity/JobInvoiceAddress');
        $listener        = new CreateJobOrder($options, $providerOptions, $priceFilter, $repository, $invoice);

        return $listener;
    }
}
