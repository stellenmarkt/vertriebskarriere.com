<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Filter;

use Zend\Filter\Exception;
use Zend\Filter\FilterInterface;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class PdfFileUri implements FilterInterface
{
    private $path;

    public function __construct($path = null) {
        $this->path = $path;
    }

    public function filter($value)
    {
        $value['uri'] = $this->path . str_replace('public/', '', $value['tmp_name']);

        return $value;
    }
}
