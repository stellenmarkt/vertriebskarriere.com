<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Entity\Product;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * ${CARET}
 *
 * @ODM\MappedSuperclass
 *
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
abstract class AbstractProduct implements ProductInterface
{
    const ENDDATE = 'now + 1 year';

    /**
     *
     * @ODM\Field(type="tz_date")
     * @var \DateTime
     */
    protected $startDate;

    /**
     *
     * @ODM\Field(type="tz_date")
     * @var \DateTime
     */
    protected $endDate;

    /**
     *
     * @ODM\Field(type="int")
     * @var int
     */
    protected $jobCount = 0;

    protected $jobAmount;

    public function __construct()
    {
        $this->startDate = new \DateTime();
        $this->endDate   = new \DateTime(static::ENDDATE);
    }

    public function isExpired()
    {
        $now = new \DateTime();

        return $now > $this->endDate;
    }

    public function getAvailableJobAmount()
    {
        return $this->jobAmount;
    }

    public function hasAvailableJobAmount()
    {
        return null === $this->jobAmount || $this->jobAmount > $this->jobCount;
    }

    public function getStartDate()
    {
        return clone $this->startDate;
    }

    public function getEndDate()
    {
        return clone $this->endDate;
    }

    public function getJobCount()
    {
        return $this->jobCount;
    }

    public function increaseJobCount()
    {
        if (!$this->hasAvailableJobAmount()) {
            throw new \Exception('Job amount exceeded.');
        }

        $this->jobCount += 1;
    }

    public function decreaseJobCount()
    {
        if ($this->jobCount) {
            $this->jobCount -= 1;
        }
    }
}
