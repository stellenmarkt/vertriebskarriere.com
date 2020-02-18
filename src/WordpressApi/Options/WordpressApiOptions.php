<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\WordpressApi\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class WordpressApiOptions extends AbstractOptions
{
    /**
     *
     *
     * @var string
     */
    private $baseUrl;

    /**
     *
     *
     * @var array|null
     */
    private $httpClientOptions;

    /**
     *
     *
     * @var array|null
     */
    private $cacheOptions;

    /**
     * @var array
     */
    private $idMap = [];

    /**
     * @param string $baseUrl
     *
     * @return self
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param array|null $cacheOptions
     *
     * @return self
     */
    public function setCacheOptions($cacheOptions)
    {
        $this->cacheOptions = $cacheOptions;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getCacheOptions()
    {
        return $this->cacheOptions;
    }

    /**
     * @param array|null $httpClientOptions
     *
     * @return self
     */
    public function setHttpClientOptions($httpClientOptions)
    {
        $this->httpClientOptions = $httpClientOptions;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getHttpClientOptions()
    {
        return $this->httpClientOptions;
    }

    /**
     * @param array $idMap
     *
     * @return self
     */
    public function setIdMap($idMap)
    {
        $this->idMap = $idMap;

        return $this;
    }

    /**
     * @return array
     */
    public function getIdMap()
    {
        return $this->idMap;
    }

    
}