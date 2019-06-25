<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Form;

use Core\Form\Form;
use Core\Form\ViewPartialProviderInterface;
use Core\Form\ViewPartialProviderTrait;


/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class UserProductInfo extends Form implements ViewPartialProviderInterface
{
    use ViewPartialProviderTrait;

    private $defaultPartial = 'jobs-frankfurt/jobs/user-product-info';

    public function setObject($object)
    {
        $this->object = $object;
    }


}
