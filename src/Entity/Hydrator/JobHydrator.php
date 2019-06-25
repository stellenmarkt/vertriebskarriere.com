<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Entity\Hydrator;

use Core\Entity\Hydrator\EntityHydrator;
use Jobs\Entity\JobSnapshot;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class JobHydrator extends EntityHydrator
{
    public function extract($object)
    {
        $data = parent::extract($object);

        $template = $object->getAttachedEntity('gastro24-template');

        if ($template) {
            $data['gastro24-template'] = $template;
        }

        return $data;
    }

    public function hydrate(array $data, $object)
    {
        if (isset($data['gastro24-template'])) {
            /* @var \Gastro24\Entity\Template $template */
            $template = $data['gastro24-template'];
            $logo = $template->getLogo();
            $image = $template->getImage();

            $newTemplate = $object->getAttachedEntity('gastro24-template');
            if (!$newTemplate) {
                $newTemplate = new \Gastro24\Entity\Template();
                $object->addAttachedEntity($template, 'gastro24-template');
            }

            $logo  && $newTemplate->setLogo($logo);
            $image && $newTemplate->setImage($image);

            unset($data['gastro24-template']);
        }

        return parent::hydrate($data, $object);
    }


}
