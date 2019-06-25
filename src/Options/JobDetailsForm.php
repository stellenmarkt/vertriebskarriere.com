<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
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
class JobDetailsForm extends AbstractOptions
{
    private $labels = [
        'mode' => [
            'uri' => 'Direktlink-Inserat',
            'pdf' => 'PDF-Inserat',
            'html' => 'Standard-Inserat',
        ],
        'uri' => 'Link zum Stelleninserat',
        'pdf' => 'PDF-Datei hochladen',
        'logo' => 'Unternehmenslogo (max. 350x150)',
        'description' => 'Unternehmensbeschreibung',
        'image' => 'Bannerbild (max. 600x400)',
        'position' => 'Stellenbeschreibung',
        'requirements' => 'Anforderungen',
    ];

    private $imageSize = [
        'width' => 0,
        'height' => 0,
        'min-width' => 0,
        'min-height' => 0,
        'max-height' => 0,
        'max-width' => 0,
    ];

    private $logoSize = [
        'width' => 0,
        'height' => 0,
        'min-width' => 0,
        'min-height' => 0,
        'max-height' => 0,
        'max-width' => 0,
    ];

    /**
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    public function getLabel($key)
    {
        return isset($this->labels[$key]) ? $this->labels[$key] : '';
    }

    /**
     * @param array $labels
     *
     * @return self
     */
    public function setLabels($labels)
    {
        $this->labels = array_merge($this->labels, $labels);

        return $this;
    }

    /**
     * @return array
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * @param array $imageSize
     *
     * @return self
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = array_merge($this->imageSize, $imageSize);

        return $this;
    }

    /**
     * @return array
     */
    public function getLogoSize()
    {
        return $this->logoSize;
    }

    /**
     * @param array $logoSize
     *
     * @return self
     */
    public function setLogoSize($logoSize)
    {
        $this->logoSize = array_merge($this->logoSize, $logoSize);

        return $this;
    }


}
