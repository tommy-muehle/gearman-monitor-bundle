<?php

namespace EnlightenedDC\GearmanMonitorBundle\Model;

/**
 * Class Status
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
     * @param string $jobName
     * @param int    $queuedJobs
     * @param int    $runningJobs
     * @param int    $availableWorkers
     */
    public function __construct($jobName, $queuedJobs, $runningJobs, $availableWorkers)
    {
        $this->jobName = $jobName;
        $this->queuedJobs = $queuedJobs;
        $this->runningJobs = $runningJobs;
        $this->availableWorkers = $availableWorkers;
    }

    /**
     * @return string
     */
    public function getJobName()
    {
        return $this->jobName;
    }

    /**
     * @return int
     */
    public function getQueuedJobs()
    {
        return $this->queuedJobs;
    }

    /**
     * @return int
     */
    public function getRunningJobs()
    {
        return $this->runningJobs;
    }

    /**
     * @return int
     */
    public function getAvailableWorkers()
    {
        return $this->availableWorkers;
    }
}
