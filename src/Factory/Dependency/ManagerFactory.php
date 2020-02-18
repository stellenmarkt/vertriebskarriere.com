<?php
/**
 * Yawik DemoSkin
 */

/**  */
namespace JobsFrankfurt\Factory\Dependency;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 *
 *
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 */
class ManagerFactory implements FactoryInterface
{
	/**
	 * Create new Manager
	 *
	 * @param ContainerInterface $container
	 * @param string $requestedName
	 * @param array|null $options
	 *
	 * @return \Gastro24\Dependency\Manager
	 */
	public function __invoke( ContainerInterface $container, $requestedName, array $options = null )
	{
		$manager = new \Gastro24\Dependency\Manager($container->get('Core/DocumentManager'));
		$manager->setEventManager($container->get('Auth/Dependency/Manager/Events'));
		
		return $manager;
	}
}
