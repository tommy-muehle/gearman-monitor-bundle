<?php

namespace EnlightenedDC\GearmanMonitorBundle\Service;

use EnlightenedDC\GearmanMonitorBundle\Exception\GearmanConnectionException;
use EnlightenedDC\GearmanMonitorBundle\Model\Status;

/**
 * Class Monitor
 *
 * @package EnlightenedDC\GearmanMonitorBundle\Service
 */
class Monitor
{
    /**
     * @var Connector
     */
    private $connector;

    /**
     * @param string $host
     * @param int    $port
     */
    public function __construct($host, $port)
    {
        $this->connector = new Connector($host, $port);
    }

    /**
     * @param string $job
     *
     * @return Status[]
     */
    public function getStatusData($job = null)
    {
        $statusData = [];

        foreach ($this->connector->call() as $line) {
            list($jobName, $queuedJobs, $runningJobs, $availableWorkers) = explode("\t", $line);

            if (null !== $job && $job !== $jobName) {
                continue;
            }

            $status = new Status();
            $status->setJobName($jobName);
            $status->setQueuedJobs($queuedJobs);
            $status->setRunningJobs($runningJobs);
            $status->setAvailableWorkers($availableWorkers);

            $statusData[] = $status;
        }

        return $statusData;
    }
}
