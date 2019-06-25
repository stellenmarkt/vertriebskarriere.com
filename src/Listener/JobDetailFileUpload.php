<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Listener;

use Core\Listener\Events\AjaxEvent;
use Doctrine\ODM\MongoDB\DocumentRepository;
use JobsFrankfurt\Form\JobDetailsForm;
use Zend\Stdlib\ArrayUtils;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class JobDetailFileUpload 
{

    private $form;

    private $repository;

    public function __construct(JobDetailsForm $form, DocumentRepository $repository)
    {
        $this->form = $form;
        $this->repository = $repository;
    }

    public function __invoke(AjaxEvent $event)
    {
        $mode    = isset($_POST['details']['mode']) ? $_POST['details']['mode'] : null;

        if (!$mode) {
            return;
        }

        $files   = $event->getRequest()->getFiles()->toArray();
        $data    = ArrayUtils::merge($_POST, $files);


        if ('pdf' == $mode) {
            return $this->uploadPdf($event, $data);
        }

        return $this->uploadTemplateImage($event, $data);
    }

    public function uploadPdf($event, $data)
    {
        $this->form->setData($data);
        $this->form->setValidationGroup(['details' => ['mode', 'pdf']]);

        if ($this->form->isValid()) {
            $values = $this->form->getData();
            return ['valid' => true, 'content' => '
                <a href="' . $values['details']['pdf']['uri'] . '" target="_blank">' . basename($values['details']['pdf']['uri']) . '</a>
                <a href="?ajax=jobdetailsdelete&file=' .basename($values['details']['pdf']['uri']). '" class="file-delete btn btn-default btn-xs">
        <span class="yk-icon yk-icon-minus"></span>
    </a>
    <input type="hidden" value="' . $values['details']['pdf']['uri'] . '" name="pdf_uri">'
            ];
        }

        $values = $this->form->getData();
        @unlink($values['details']['pdf']['tmp_name']);
        return ['valid' => false, 'errors' => $this->form->getMessages()];
    }

    public function deletePdfFile(AjaxEvent $event)
    {
        $file = $event->getRequest()->getQuery('file');
        @unlink('public/static/jobs/' . $file);

        return ['ok' => true];
    }

    public function uploadTemplateImage($event, $data)
    {
        $name = isset($data['details']['logo']) && !empty($data['details']['logo']) ? 'logo' : 'image';
        $this->form->setData($data);
        $this->form->setValidationGroup(['details' => ['mode', $name]]);

        if ($this->form->isValid()) {
            $values = $this->form->getData();
            $file = $values['details'][$name]['entity'];

            return [
                'valid' => true,
                'content' => '
                    <a href="/' . $file->getUri() . '" target="_blank">'
                    . $file->getName() . '</a>'
                    . '<a href="/' . $file->getUri() . '?do=delete" class="file-delete btn btn-default btn-xs">
                    <span class="yk-icon yk-icon-minus"></span>
                        </a>
                        <input type="hidden" value="' . $file->getId() . '" name="details[' . $name . '_id]">'
            ];
        }

        $values = $this->form->getData();
        if (isset($values['details'][$name]['entity']) && !empty($values['details'][$name]['entity'])) {
            $this->repository->getDocumentManager()->remove($values['details'][$name]['entity']);
        }

        return ['valid' => false, 'errors' => $this->form->getMessages() ];
    }
}
