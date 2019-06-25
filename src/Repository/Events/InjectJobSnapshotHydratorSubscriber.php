<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Repository\Events;

use Core\Repository\SnapshotRepository;
use Doctrine\Common\EventSubscriber;
use \Core\Repository\DoctrineMongoODM\Event\EventArgs;
use JobsFrankfurt\Entity\Hydrator\JobHydrator;
use Jobs\Entity\JobSnapshot;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class InjectJobSnapshotHydratorSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            \Core\Repository\DoctrineMongoODM\Event\RepositoryEventsSubscriber::postConstruct,
        ];
    }

    public function postRepositoryConstruct(EventArgs $eventArgs)
    {
        $repository = $eventArgs->get('repository');

        if ($repository instanceOf SnapshotRepository && JobSnapshot::class == $repository->getDocumentName()) {
            $repository->setHydrator(new JobHydrator());
            $snapshot = new \ReflectionClass(JobSnapshot::class);
            $props    = $snapshot->getDefaultProperties();
            $attributes = $props['snapshotAttributes'];
            $attributes[] = 'gastro24-template';

            $repository->setSnapshotAttributes($attributes);
        }
    }

}
