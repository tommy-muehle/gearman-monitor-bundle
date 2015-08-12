<?php

namespace EnlightenedDC\GearmanMonitorBundle\Service;

use EnlightenedDC\GearmanMonitorBundle\Exception\NoGearmanConnectionException;
use EnlightenedDC\GearmanMonitorBundle\Model\Status;

/**
 * Class Monitor
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
     * @return array
     *
     * @throws NoGearmanConnectionException
     */
    public function getInformations($job = null)
    {
        $status = [];

        foreach ($this->connector->call() as $line) {
            list($name, $total, $running, $availableWorkers) = explode("\t", $line);

            if (null !== $job && $job !== $name) {
                continue;
            }

            $status[] = new Status($name, $total, $running, $availableWorkers);
        }

        return $status;
    }
}
