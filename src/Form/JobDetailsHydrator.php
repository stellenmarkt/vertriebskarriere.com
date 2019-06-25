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

use JobsFrankfurt\Entity\Template;
use JobsFrankfurt\Entity\TemplateImage;
use Zend\Hydrator\HydratorInterface;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class JobDetailsHydrator implements HydratorInterface
{
    private $repositories;

    public function __construct($repositories)
    {
        $this->repositories = $repositories;
    }

    public function extract($object)
    {
        $link = $object->getLink();
        if ('.pdf' == substr($link, -4)) {
            $mode = 'pdf';
        } else if ($link) {
            $mode = 'uri';
        } else {
            $mode = 'html';
        }

        $template = $object->getAttachedEntity('gastro24-template');
        $image    = $template && ($image = $template->getImage()) ? $image->getUri() : null;

        return [
            'mode' => $mode,
            'uri' => $mode == 'uri' ? $link : '',
            'pdf' => $mode == 'pdf' ? $link : '',
            //'description' => $object->getTemplateValues()->getDescription(),
            'position' => $object->getTemplateValues()->get('position'),
            'requirements' => $object->getTemplateValues()->getRequirements(),
            'image' => $image,
        ];
    }

    public function hydrate(array $data, $object)
    {
        /* @var \Jobs\Entity\Job $object */
        if ('html' == $data['mode']) {
            $link = $object->getLink();
            if ('.pdf' == substr($link, -4)) {
                @unlink('public/' . $link);
            }
            $object->setLink('');
            $object->getTemplateValues()->setDescription($data['description']);
            $object->getTemplateValues()->position = $data['position'];
            $object->getTemplateValues()->setRequirements($data['requirements']);
            $template = $object->getAttachedEntity('gastro24-template');
            $repository = $this->repositories->get(TemplateImage::class);
            if (!$template) {
                $template = new Template();
                $this->repositories->store($template);
                $object->addAttachedEntity($template, 'gastro24-template');
            }
            if (isset($_POST['details']['logo_id'])) {
                $file = $repository->find($_POST['details']['logo_id']);
                $template->setLogo($file);
            }
            if (isset($_POST['details']['image_id'])) {
                $file = $repository->find($_POST['details']['image_id']);
                $template->setImage($file);
            }

        } else {
            $object->setLink('uri' == $data['mode'] ? $data['uri'] : (isset($_POST['pdf_uri']) ? $_POST['pdf_uri'] : $data['pdf']));
        }

        return $object;
    }

}
