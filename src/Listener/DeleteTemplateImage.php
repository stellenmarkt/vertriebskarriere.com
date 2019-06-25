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

use Core\Listener\Events\FileEvent;
use Doctrine\ODM\MongoDB\DocumentRepository;
use JobsFrankfurt\Entity\TemplateImage;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class DeleteTemplateImage 
{

    private $repository;

    public function __construct(DocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FileEvent $event)
    {
        $file = $event->getFile();

        if (! $file instanceOf TemplateImage) {
            return;
        }

        $imageId = new \MongoId($file->getId());

        foreach ($this->repository->findBy(['image' => $imageId]) as $template) {
            /* @var \Gastro24\Entity\Template $template */
            $template->clearImage();
        }

        foreach ($this->repository->findBy(['logo' => $imageId]) as $template) {
            $template->clearLogo();
        }
    }
}
