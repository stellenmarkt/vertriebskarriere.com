<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013 - 2016 Cross Solution (http://cross-solution.de)
 * @license   MIT
 */

/**  */
namespace JobsFrankfurt\Form;

use Core\Form\FileUploadFactory;
use Core\Form\Element\FileUpload;
use Core\Form\Form;
use Laminas\Stdlib\AbstractOptions;
use Applications\Options\ModuleOptions;

/**
 * Factors a file upload form to attach files to an application.
 *
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 */
class JobPdfFactory extends FileUploadFactory
{
    /**
     * Form element for the file upload
     *
     * @var string
     */
    protected $fileElement = 'Core/FileUpload';

    /**
     * Name of the file, if downloaded.
     *
     * @var string
     */
    protected $fileName = 'pdf';

    /**
     * Entity for storing the attachment
     *
     * @var string
     */
    protected $fileEntityClass = '\Core\Entity\FileEntity';

    /**
     * allow to upload multiple files
     *
     * @var bool
     */
    protected $multiple = false;

    /**
     * use abstract options defined in "Applications/Options"
     *
     * @var string
     */
    protected $options='JobsFrankfurt/WordpressApiOptions';



}
