<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\ContactForm\Options;

use Core\Options\FieldsetCustomizationOptions;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class ContactFormFormOptions extends FieldsetCustomizationOptions
{

    protected $fields = [
        'organization' => [
            'required' => true,
            'options' => [
                'label' => 'Unternehmen*',
            ],
        ],

        'name' => [
            'required' => true,
            'options' => [
                'label' => 'Ansprechperson*',
            ],
        ],

        'phonenumber' => [
            'required' => false,
        ],

        'email' => [
            'required' => true,
            'options' => [
                'label' => 'E-Mail*',
            ],
        ],

        'website' => [
            'required' => true,
            'options' => [
                'label' => 'Website*',
            ],
        ],

        'message' => [
            'required' => true,
            'options' => [
                'label' => 'Nachricht*',
            ],
        ],
    ];
    
}
