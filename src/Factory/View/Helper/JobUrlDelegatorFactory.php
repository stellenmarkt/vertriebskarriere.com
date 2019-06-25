<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Factory\View\Helper;

use JobsFrankfurt\View\Helper\JobUrlDelegator;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\DelegatorFactoryInterface;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class JobUrlDelegatorFactory implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $originalHelper = $callback();
        $helpers   = $container->get('ViewHelperManager');
        $urlHelper = $helpers->get('url');
        $serverUrlHelper = $helpers->get('serverUrl');
        $delegator      = new JobUrlDelegator($originalHelper, $urlHelper, $serverUrlHelper);

        return $delegator;
    }


}
