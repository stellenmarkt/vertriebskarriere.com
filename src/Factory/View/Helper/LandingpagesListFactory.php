<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Factory\View\Helper;

use JobsFrankfurt\View\Helper\LandingpagesList;
use JobsFrankfurt\WordpressApi\Service\WordpressClient;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for \Gastro24\View\Helper\LandingpagesList
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @author Anthonius Munthi <me@itstoni.com>
 * @todo write test  
 */
class LandingpagesListFactory implements FactoryInterface
{
	/**
	 * @param ContainerInterface $container
	 * @param string $requestedName
	 * @param array|null $options
	 *
	 * @return LandingpagesList
	 */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $client  = $container->get(WordpressClient::class);
        $options = $container->get('JobsFrankfurt/WordpressApiOptions');
        $idMap   = $options->getIdMap();

        return new LandingpagesList($client, $idMap);
    }
}
