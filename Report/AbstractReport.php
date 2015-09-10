<?php

namespace EnlightenedDC\GearmanMonitorBundle\Report;

use EnlightenedDC\Gearman\Response;
use EnlightenedDC\GearmanMonitorBundle\Gearman\State;

/**
 * Class AbstractReport
 *
 * @package EnlightenedDC\GearmanMonitorBundle\Report
 */
abstract class AbstractReport
{
    const TAB = "\t";

    /**
     * @var array
     */
    protected $ignores = [
        'server' => [],
        'jobs' => [],
    ];

    /**
     * @var array
     */
    protected $states = [];

    /**
     * @param $name
     */
    public function ignoreServer($name)
    {
        $this->ignores['server'][] = $name;
    }

    /**
     * @param $name
     */
    public function ignoreJob($name)
    {
        $this->ignores['jobs'][] = $name;
    }

    /**
     * @param string   $serverName
     * @param Response $response
     */
    public function addStates($serverName, Response $response)
    {
        foreach ($response->getLines() as $line) {
            list($jobName, $queuedJobs, $runningJobs, $availableWorkers) = explode(self::TAB, $line);

            if (null !== $this->ignores['server'][$serverName]) {
                continue;
            }

            if (null !== $this->ignores['jobs'][$jobName]) {
                continue;
            }

            $this->states[$serverName][] = new State($jobName, $queuedJobs, $runningJobs, $availableWorkers);
        }
    }

    /**
     * @return string
     */
    abstract public function render();
}
