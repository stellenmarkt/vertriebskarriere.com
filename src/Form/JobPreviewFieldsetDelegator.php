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

use Jobs\Form\PreviewFieldset;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class JobPreviewFieldsetDelegator extends PreviewFieldset
{
    public function init()
    {
        parent::init();

        $terms = $this->get('termsAccepted');
        $terms->setOption('route', 'lang/wordpress');
        $terms->setOption('params', [
                'type' => 'page',
                'id'   => 'agb',
        ]);
    }
}
