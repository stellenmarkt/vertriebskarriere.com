<?php
/**
 * YAWIK
 *
 * @filesource
 * @license    MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */

/** */

namespace JobsFrankfurt\Listener;

use JobsFrankfurt\Entity\UserProduct;
use Jobs\Listener\Events\JobEvent;

/**
 * ${CARET}
 *
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo   write test
 */
class IncreaseJobCount
{

    public function __invoke(JobEvent $event)
    {
        /* @var \Auth\Entity\User $owner
         * @var \Gastro24\Entity\UserProduct $productWrapper
         */
        $job     = $event->getJobEntity();
        $company = $job->getOrganization();

        if (!$company) {
            return;
        }

        $owner = $company->getUser();

        if (!$owner) {
            return;
        }

        $productWrapper = $owner->getAttachedEntity(UserProduct::class);

        if (!$productWrapper) {
            return;
        }
        
        $product        = $productWrapper->getProduct();

        $product->increaseJobCount();
    }
}
