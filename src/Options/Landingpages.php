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
class Landingpages extends AbstractOptions
{

    private $idMap = [];

    private $queryMap = [];

    private $tabs = [];
    
    private $companies = [];

    public function setFromArray($options)
    {
        $idMap = [];
        $queryMap = [];
        $tabs = [];
        $companies = [];

        foreach ($options as $term => $spec) {
            if (isset($spec['id'])) {
                $idMap[$term] = $spec['id'];
            }

            if (isset($spec['company'])) {
                if (!isset($spec['query'])) {
                    $spec['query'] = [ 'organizationTag' => [$spec['company'] => 1]];
                } else if (!isset($spec['query']['organizationTag'])) {
                    $spec['query']['organizationTag'] = [$spec['company'] => 1];
                }
                
                $companies[$term] = [isset($spec['text'])?$spec['text'] : $term, isset($spec['logo']) ? $spec['logo'] : false];
            }

            if (isset($spec['query']) && !isset($spec['query']['q'])) {
                $spec['query']['q'] = '';
            }

            $queryMap[ $term ] = isset($spec[ 'query' ]) ? $spec[ 'query' ] : ['q' => $term];

            if (isset($spec['tab']) && isset($spec['panel'])) {
                $tabs[ $spec[ 'tab' ] ][ $spec[ 'panel' ] ][] = [$term, $spec[ 'text' ]];
            }
            
            

        }

        return parent::setFromArray(['idMap' => $idMap, 'queryMap' => $queryMap, 'tabs' => $tabs, 'companies' => $companies ]);
    }

    /**
     * @return array
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * @param array $companies
     *
     * @return self
     */
    public function setCompanies($companies)
    {
        $this->companies = $companies;

        return $this;
    }



    /**
     * @return array
     */
    public function getIdMap($term = null, $default = null)
    {
        if (null === $term) {
            return $this->idMap;
        }

        return isset($this->idMap[$term]) ? $this->idMap[$term] : $default;
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
    public function getQueryMap()
    {
        return $this->queryMap;
    }

    public function getQueryParameters($term)
    {
        return isset($this->queryMap[$term]) ? $this->queryMap[$term] : [];
    }

    /**
     * @param array $queryMap
     *
     * @return self
     */
    public function setQueryMap($queryMap)
    {
        $this->queryMap = $queryMap;

        return $this;
    }

    /**
     * @return array
     */
    public function getTabs()
    {
        return $this->tabs;
    }

    /**
     * @param array $tabs
     *
     * @return self
     */
    public function setTabs($tabs)
    {
        $this->tabs = $tabs;

        return $this;
    }



}
