<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class JobsearchQueries extends AbstractOptions
{
    /**
     *
     *
     * @var array
     */
    private $config;

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $queries
     *
     * @return self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    public function getTabs()
    {
        return array_keys($this->config);
    }

    public function getSections($tab)
    {
        $sections = $this->config[$tab];

        return array_keys($sections);
    }

    public function getQueries($tab, $section)
    {
        return $this->config[$tab][$section];
    }
}
