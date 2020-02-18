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

use Core\Entity\Hydrator\EntityHydrator;
use Core\Form\ViewPartialProviderInterface;
use Core\Form\ViewPartialProviderTrait;
use JobsFrankfurt\Filter\PdfFileUri;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class JobDetails extends Fieldset implements InputFilterProviderInterface, ViewPartialProviderInterface
{
    use ViewPartialProviderTrait;

    private $defaultPartial = 'jobs-frankfurt/form/job-details-fieldset';

    private $gastroOptions;

    public function getHydrator()
    {
        if (!$this->hydrator) {
            $hydrator = new EntityHydrator();
            $this->setHydrator($hydrator);
        }
        return $this->hydrator;
    }

    /**
     * @param mixed $gastroOptions
     *
     * @return self
     */
    public function setGastroOptions($gastroOptions)
    {
        $this->gastroOptions = $gastroOptions;

        return $this;
    }

    public function init()
    {

        $this->add([
            'type' => 'radio',
            'name' => 'mode',
            'options' => [
                'value_options' => [
                    'uri' => 'uri',
                    'pdf' => 'pdf',
                    'html' => 'html'
                ],
                'labels' => $this->gastroOptions->getLabel('mode'),
            ],
            'attributes' => [
                'value' => 'uri',
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'uri',
            'options' => [
                'description' => 'Geben Sie die Online-Addresse des Inserats an.',
                'label' => $this->gastroOptions->getLabel('uri'),
                'rowClass' => 'csj-uri-wrapper'
            ],
            'attributes' => [
                'placeholder' => 'http://',
                //'id' => 'csj-uri',
            ]
        ]);

        $this->add([
            'type' => 'File',
            'name' => 'pdf',
            'options' => [
                'description' => 'Selektieren Sie hier das PDF-Dokument Ihres Jobs.',
                'label' => $this->gastroOptions->getLabel('pdf'),
                'rowClass' => 'csj-pdf-wrapper',
            ],
            'attributes' => [
                //'id' => 'csj-pdf',
            ],
        ]);

        $this->add([
            'type' => 'File',
            'name' => 'logo',
            'options' => [
                'label' => $this->gastroOptions->getLabel('logo'),
            ],
        ]);

        $this->add([
            'type' => 'TextEditor',
            'name' => 'description',
            'options' => [
                'description' => 'Geben Sie die Beschreibung Ihres Unternehmens ein.',
                'label' => $this->gastroOptions->getLabel('description'),
                'rowClass' => 'csj-html-input',
                'no-submit' => true,
            ],
            'attributes' => [
                'data-toggle' => 'description',
                'data-target' => 'details-description',
                'style' => 'height: auto;',
            ],
        ]);



        $this->add([
            'type' => 'File',
            'name' => 'image',
            'options' => [
                'label' => $this->gastroOptions->getLabel('image'),
            ]
        ]);

        $this->add([
            'type' => 'TextEditor',
            'name' => 'position',
            'options' => [
                'description' => 'Geben Sie die Beschreibung der beworbenen Stelle ein.',
                'label' => $this->gastroOptions->getLabel('position'),
                'rowClass' => 'csj-html-input',
                'no-submit' => true,
            ],
            'attributes' => [
                'data-toggle' => 'description',
                'data-target' => 'details-position',
                'style' => 'height: auto;',
            ],
        ]);

        $this->add([
            'type' => 'TextEditor',
            'name' => 'requirements',
            'options' => [
                'description' => 'Geben Sie die Anforderungen an die Bewerber an.',
                'label' => $this->gastroOptions->getLabel('requirements'),
                'rowClass' => 'csj-html-input',
                'no-submit' => true,
            ],
            'attributes' => [
                'data-toggle' => 'description',
                'data-target' => 'details-requirements',
                'style' => 'height: auto;',
            ],
        ]);



    }

    public function getInputFilterSpecification()
    {
        $spec = [];
        $mode = $this->get('mode')->getValue();


        if ('pdf' == $mode) {
            $spec['pdf'] = [
                'require' => !isset($_POST['pdf_uri']),
                'allow_empty' => isset($_POST['pdf_uri']),
                'validators' => [
                    [
                        'name' => 'FileMimeType',
                        'options' => [
                            'mimeType' => 'application/pdf',
                            'disableMagicFile' => true,
                            'magicFile' => false,
                        ]
                    ],
                    [
                        'name' => 'FileExtension',
                        'options' => [
                            'extension' => 'pdf',
                        ],
                    ],
                ],
                'filters' => [
                    [
                        'name' => 'FileRenameUpload',
                        'options' => [
                            'target' =>  'public/static/jobs/job.pdf',
                            'randomize' => true,
                        ],
                    ],
                    [
                        'name' => PdfFileUri::class
                    ],
                ],
            ];
        } else if ('uri' == $mode) {
            $spec['uri'] = [ 'require' => true ];
        } else {
            $spec += [
                //'description' => [ 'require' => true ],
                //'position'    => [ 'require' => false ],
                //'requirements' => [ 'require' => false ],
                'logo' => [
                    'allow_empty' => true,
                    'validators' => [
                        [
                            'name' => 'FileMimeType',
                            'options' => [
                                'mimeType' => 'image',
                                'disableMagicFile' => true,
                                'magicFile' => false,
                            ],
                        ],
                    ],
                    'filters' => [
                        [
                            'name' => \Core\Filter\File\Resize::class,
                            'options' => $this->gastroOptions->getLogoSize(),
                        ],
                        [
                            'name' => \Core\Filter\File\Entity::class,
                            'options' => [
                                'file_entity' => \Gastro24\Entity\TemplateImage::class,
                                'repository' => true,
                            ],
                        ],
                    ],
                ],
                'image' => [
                    'allow_empty' => true,
                    'validators' => [
                        [
                            'name' => 'FileMimeType',
                            'options' => [
                                'mimeType' => 'image',
                                'disableMagicFile' => true,
                                'magicFile' => false,
                            ],
                        ],
                    ],
                    'filters' => [
                        [
                            'name' => \Core\Filter\File\Resize::class,
                            'options' => $this->gastroOptions->getImageSize(),
                        ],
                        [
                            'name' => \Core\Filter\File\Entity::class,
                            'options' => [
                                'file_entity' => \Gastro24\Entity\TemplateImage::class,
                                'repository' => true,
                            ],
                        ],
                    ],
                ],
            ];
        }



        return $spec;
    }
}
