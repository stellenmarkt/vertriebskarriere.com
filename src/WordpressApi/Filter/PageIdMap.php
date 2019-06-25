<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\WordpressApi\Filter;

use Zend\Filter\Exception;
use Zend\Filter\FilterInterface;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class PageIdMap implements FilterInterface
{

    private $map = [];

    public function __construct(array $map = [])
    {
        $this->map = $map;
    }

    /**
     * Returns the mapped page id.
     *
     * @param int|string $value
     *
     * @return int
     */
    public function filter($value)
    {
        return isset($this->map[$value]) ? $this->map[$value] : $value;
    }
}