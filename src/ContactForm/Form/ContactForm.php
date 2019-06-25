<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\ContactForm\Form;

use Core\Form\CustomizableFieldsetInterface;
use Core\Form\CustomizableFieldsetTrait;
use Core\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class ContactForm extends Form implements InputFilterProviderInterface, CustomizableFieldsetInterface
{
    use CustomizableFieldsetTrait;

    public function init()
    {
        $this->add([
            'type' => 'text',
            'name' => 'organization',
            'options' => [
                'label' => 'Unternehmen',
                'description' => 'Name des Unternehmens.',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'name',
            'options' => [
                'label' => 'Name',
                'description' => 'Geben Sie Ihren Namen ein.',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'phonenumber',
            'options' => [
                'label' => 'Telefon',
                'description' => 'Geben Sie eine Telefonnummer für evtl. Rückfragen an.',
            ],
        ]);

        $this->add([
            'type' => 'email',
            'name' => 'email',
            'options' => [
                'label' => 'E-Mail',
                'description' => 'Geben Sie Ihre E-Mail-Addresse ein.',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'website',
            'options' => [
                'label' => 'Name',
                'description' => 'Geben Sie die Website ein.',
            ],
        ]);

        $this->add([
            'type' => 'textarea',
            'name' => 'message',
            'options' => [
                'label' => 'Nachricht',
                'description' => 'Schreiben Sie hier Ihre Mitteilung.'
            ]
        ]);

        $this->add(
            array(
                'type' => 'Button',
                'name' => 'submit',
                'options' => array(
                    'label' => /*@translate*/ 'Senden',
                ),
                'attributes' => array(
                    'type' => 'submit',
                    'value' => 'Senden',
                    'class' => 'cam-btn-save pull-right'
                ),
            )
        );

        $this->setDescription('Füllen Sie die mit "*" gekennzeichneten Felder aus.');
        $this->setIsDescriptionsEnabled(true);
        $this->setName('contact-form');
        $this->setAttribute('data-handle-by', 'native');
    }

    protected function getDefaultInputFilterSpecification()
    {
        return [
            'organization' => [
                'filters' => [
                    ['name' => 'StringTrim'],
                ],
            ],
            'name' => [
                'filters' => [
                    ['name' => 'StringTrim'],
                ],
            ],
            'phonenumber' => [
                'filters' => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    ['name' => 'regex', 'options' => [
                        'pattern' => '~^[0-9 /\+]*$~',
                        'message' => 'Es sind nur Ziffern, "/" und "+" erlaubt',
                        'translatorTextDomain' => 'Gastro24',
                    ]],
                ],
            ],
            'email' => [
                'filters' => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    ['name' => 'emailaddress']
                ],
            ],
            'website' => [
                'filters' => [
                    ['name' => 'StringTrim'],
                ],
            ],
            'message' => [
                'filters' => [
                    [
                        'name' => 'StripTags',
                        'options' => [
                            'allowTags' => ['b', 'i', 'em', 'strong', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'a', 'img'],
                            'allowAttribs' => ['href', 'src'],
                        ],
                    ],
                ],
            ],
        ];
    }


}
