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

use Organizations\Entity\Organization;
use Zend\Stdlib\AbstractOptions;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class CompanyTemplatesMap extends AbstractOptions
{
    private $map = [];

    protected function setMap(array $map)
    {
        $this->map = $map;
    }

    public function getTemplate($organization)
    {
        if ($organization instanceOf Organization) {
            $organization = $organization->getId();
        }

        if (!is_string($organization)) {
            return null;
        }

        return isset($this->map[$organization]) ? $this->map[$organization] : null;
    }

    public function hasTemplate($organization)
    {
        return null !== $this->getTemplate($organization);
    }
}
