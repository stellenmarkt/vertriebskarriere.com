<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\WordpressApi\Service;

use Laminas\Cache\Storage\StorageInterface;
use Laminas\Cache\StorageFactory;
use Laminas\Http\Client;
use Laminas\Http\Request;
use Laminas\Json\Json;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class WordpressClient implements WordpressClientInterface
{
    /**
     *
     *
     * @var Client
     */
    private $httpClient;

    /**
     *
     *
     * @var StorageInterface
     */
    private $cache;

    private $baseUrl;

    /**
     *
     *
     * @var WordpressClientPluginManager
     */
    private $pluginManager;

    public function __construct($baseUrl, $plugins)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->pluginManager = $plugins;
    }

    public function __call($method, $args)
    {
        $plugin = $this->plugin($method);

        if (is_callable($plugin)) {
            return $plugin(...$args);
        }

        return $plugin;
    }

    public function plugin($name, array $options = [])
    {
        $plugin = $this->pluginManager->get($name, $options);

        return $plugin;
    }

    /**
     * @param \Laminas\Cache\Storage\StorageInterface $cache
     *
     * @return self
     */
    public function setCache($cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return \Laminas\Cache\Storage\StorageInterface
     */
    public function getCache()
    {
        if (!$this->cache) {
            $this->cache = StorageFactory::factory([
                'adapter' => [
                    'name' => 'memory',
                    'options' => [
                        'memory_limit' => '100%',
                    ],
                ],
            ]);
        }

        return $this->cache;
    }

    /**
     * @param \Laminas\Http\Client $httpClient
     *
     * @return self
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * @return \Laminas\Http\Client
     */
    public function getHttpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new Client();
        }

        return $this->httpClient;
    }

     public function request($path, array $args = [], $method = Request::METHOD_GET)
    {
        $cache    = $this->getCache();
        $cacheKey = $path;
        if ($args) { $cacheKey .= md5(serialize($args)); }
        $hit    = false;
        $result = $cache->getItem($cacheKey, $hit);

        if ($hit) {
            return $result;
        }

        $client = $this
            ->getHttpClient()
            ->resetParameters(/*clearCookies*/ false, /*clearAuth*/ false)
            ->setParameterGet($args)
            ->setUri(rtrim($this->baseUrl, '/') . '/' . $path)
        ;

        $response = $client->send();
        $result   = $response->getBody();

        try {
            $result = Json::decode($result);
        } catch (\Laminas\Json\Exception\RuntimeException $ex) {
            return (object) ['error' => true, 'code' => 'invalid_json_response', 'message' => 'Response has invalid json format.', 'data' => ['response' => $result]];
        }

        if (isset($result->code)) {
            $result->error = true;
        } else {
            $cache->setItem($cacheKey, $result);
        }

        return $result;
    }
}