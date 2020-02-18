<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\WordpressApi\Factory\View\Helper;

use JobsFrankfurt\WordpressApi\Filter\PageIdMap;
use JobsFrankfurt\WordpressApi\Service\WordpressClient;
use JobsFrankfurt\WordpressApi\View\Helper\WordpressContent;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @author Anthonius Munthi <me@itstoni.com>
 * @todo write test 
 */
class WordpressContentFactory implements FactoryInterface
{
	/**
	 * @param ContainerInterface $container
	 * @param string $requestedName
	 * @param array|null $options
	 *
	 * @return WordpressContent
	 */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $client = $container->get(WordpressClient::class);
        $idMap  = $container->get('FilterManager')->get(PageIdMap::class);

        $helper = new WordpressContent($client, $idMap);

        return $helper;
    }
}