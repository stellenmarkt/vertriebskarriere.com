<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2016 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Form;

use Jobs\Form\JobDescription as ParentJobDescription;

/**
 * ${CARET}
 * 
 * @author Carsten Bleek <bleek@cross-solution.de>
 */
class JobsDescription extends ParentJobDescription
{

    public function init()
    {
        parent::init();

        $this->setForms([
            'details' => [
                'type' => JobDetailsForm::class,
                'property' => true,
                'options' => [
                    'use_files_array' => true,
                ],
            ],
        ]);
    }
}
