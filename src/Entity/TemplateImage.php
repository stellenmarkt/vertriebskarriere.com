<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Entity;


use Core\Entity\FileEntity;
use Core\Entity\Permissions;
use \Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * ${CARET}
 *
 * @ODM\Document(collection="gastro24.templateimages")
 *
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test
 */
class TemplateImage extends FileEntity
{
    public function getUri()
    {
        return 'file/Gastro24.TemplateImage/' . $this->id . '/' .urlencode($this->name);
    }

    public function getPermissions()
    {
        $perms = parent::getPermissions();

        if (!$perms->isGranted('all', Permissions::PERMISSION_VIEW)) {
            $perms->grant('all', Permissions::PERMISSION_VIEW);
        }

        return $perms;
    }
}
