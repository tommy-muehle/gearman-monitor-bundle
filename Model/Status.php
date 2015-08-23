<?php

namespace EnlightenedDC\GearmanMonitorBundle\Model;

/**
 * Class Status
 *
 * @package EnlightenedDC\GearmanMonitorBundle\Model
 */
class Status
{
    /**
     * @var string
     */
    private $jobName;

    /**
     * @var int
     */
    private $queuedJobs = 0;

    /**
     * @var int
     */
    private $runningJobs = 0;

    /**
     * @var int
     */
    private $availableWorkers = 0;

    /**
     * @return string
     */
    public function getJobName()
    {
        return $this->jobName;
    }

    /**
     * @param string $jobName
     */
    public function setJobName($jobName)
    {
        $this->jobName = $jobName;
    }

    /**
     * @return int
     */
    public function getQueuedJobs()
    {
        return $this->queuedJobs;
    }

    /**
     * @param int $queuedJobs
     */
    public function setQueuedJobs($queuedJobs)
    {
        $this->queuedJobs = $queuedJobs;
    }

    /**
     * @return int
     */
    public function getRunningJobs()
    {
        return $this->runningJobs;
    }

    /**
     * @param int $runningJobs
     */
    public function setRunningJobs($runningJobs)
    {
        $this->runningJobs = $runningJobs;
    }

    /**
     * @return int
     */
    public function getAvailableWorkers()
    {
        return $this->availableWorkers;
    }

    /**
     * @param int $availableWorkers
     */
    public function setAvailableWorkers($availableWorkers)
    {
        $this->availableWorkers = $availableWorkers;
    }
}
