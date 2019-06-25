<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Controller;

use JobsFrankfurt\Options\CompanyTemplatesMap;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for \Gastro24\Controller\RedirectExternalJobs
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test  
 */
class RedirectExternalJobsFactory implements FactoryInterface
{
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $validators = $container->get('ValidatorManager');
        $validator  = $validators->get(\Gastro24\Validator\IframeEmbeddableUri::class);
        $templatesMap = $container->get(CompanyTemplatesMap::class);
        $service    = new RedirectExternalJobs($validator, $templatesMap);
        
        return $service;    
    }
}
