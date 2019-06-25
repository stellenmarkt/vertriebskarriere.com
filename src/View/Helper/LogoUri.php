<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\View\Helper;

use Solr\Entity\JobProxy;
use Zend\Form\View\Helper\AbstractHelper;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class LogoUri extends AbstractHelper
{

    private $imageCache;

    public function __construct($imageCache)
    {
        $this->imageCache = $imageCache;
    }

    public function __invoke($job, $order = ['template', 'solr', 'organization'])
    {
        $uri = null;

        if (
            ($template = $job->getAttachedEntity('gastro24-template'))
            && ($logo = $template->getLogo())
        ) {
            return $this->getView()->plugin('basepath')->__invoke($logo->getUri());
        }


        if ($job instanceOf JobProxy) {
            $logo = $job->getSolrValue('companyLogo');
            if (0 === strpos($logo, 'http')) {
                return $logo;
            }
        }

        if (
            ($org = $job->getOrganization())
            && ($image = $org->getImage(true))
        ) {
            return $this->getView()->plugin('basepath')->__invoke(
                $this->imageCache->getUri($image)
            );
        }

        return '';
    }

}
