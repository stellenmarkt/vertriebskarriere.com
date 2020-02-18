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

use Organizations\Entity\OrganizationInterface;
use Laminas\View\Helper\AbstractHelper;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class OrgProfileUrl extends AbstractHelper
{

    private $urlHelper;

    public function __construct($urlHelper = null)
    {
        $this->urlHelper = $urlHelper;
    }

    public function __invoke($orgId, $orgName = null)
    {
        if ($orgId instanceOf OrganizationInterface) {
            $orgName = $orgId->getOrganizationName()->getName();
            $orgId   = $orgId->getId();
        }

        $orgName   = preg_replace(['~[^a-zA-Z0-9äüöÄÜÖ]~', '~--?~'], ['-', '-'], $orgName);
        $urlHelper = $this->getUrlHelper();
        $url       = $urlHelper('lang/organizations-profiles', ['id' => $orgId, 'name' => $orgName], true);

        return $url;

    }

    /**
     *
     *
     * @return \Laminas\View\Helper\Url
     */
    private function getUrlHelper()
    {
        if (!$this->urlHelper) {
            $this->urlHelper = $this->getView()->plugin('url');
        }

        return $this->urlHelper;
    }
}
