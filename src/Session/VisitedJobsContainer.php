<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Session;

use Jobs\Entity\JobInterface;

/**
 * Wraps a SessionContainer.
 *
 * Adds methods to set and check, if a certain job was already visited or not.
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class VisitedJobsContainer
{
    private $container;

    public function __construct($namespace = 'gastro24_visitedjobs')
    {
        $this->container = new \Zend\Session\Container($namespace);
        if (!isset($this->container->visitedJobs)) {
            $this->container->visitedJobs = [];
        }
    }

    public function isVisited($jobOrId)
    {
        return in_array($this->getJobId($jobOrId), $this->container->visitedJobs);
    }

    public function add($jobOrId)
    {
        $visited   = $this->getVisited();
        $visited[] = $this->getJobId($jobOrId);
        $this->container->visitedJobs = array_unique($visited);
    }

    public function getVisited()
    {
        return $this->container->visitedJobs;
    }

    private function getJobId($jobOrId)
    {
        if (is_string($jobOrId)) { return $jobOrId; }

        if (! $jobOrId instanceof JobInterface) {
            return uniqid();
        }

        return $jobOrId->getId();
    }
}
