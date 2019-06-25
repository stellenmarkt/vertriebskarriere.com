<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Form;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for \Gastro24\Form\JobDetails
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test  
 */
class JobDetailsFactory implements FactoryInterface
{
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $hydrator = $container->get('HydratorManager')->get(JobDetailsHydrator::class);
        $detailsOptions = $container->get(\Gastro24\Options\JobDetailsForm::class);
        $service = new JobDetails();
        $service->setHydrator($hydrator);
        $service->setGastroOptions($detailsOptions);
        
        return $service;    
    }
}
