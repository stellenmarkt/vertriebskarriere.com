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

use Zend\Stdlib\AbstractOptions;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class WordpressContentSnippetOptions extends AbstractOptions
{
    /**
     * @var array
     */
    private $idMap = [];

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