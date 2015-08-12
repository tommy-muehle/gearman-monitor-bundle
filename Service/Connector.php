<?php

namespace EnlightenedDC\GearmanMonitorBundle\Service;

use EnlightenedDC\GearmanMonitorBundle\Exception\NoGearmanConnectionException;

/**
 * Class Connector
 * @package EnlightenedDC\GearmanMonitorBundle\Service
 */
class Connector
{
    /**
     * @var resource
     */
    private $handle;

    /**
     * @param string $host
     * @param int    $port
     *
     * @throws NoGearmanConnectionException
     */
    public function __construct($host, $port)
    {
        $errorNumber = 0;
        $errorMessage = '';

        $this->handle = @fsockopen($host, $port, $errorNumber, $errorMessage, 2);

        if (false === $this->handle) {
            throw new NoGearmanConnectionException;
        }
    }

    /**
     * @param string $command
     *
     * @return array
     */
    public function call($command = 'status')
    {
        $lines = [];
        fwrite($this->handle, $command . PHP_EOL);

        while(!feof($this->handle)) {
            $response = trim(fgets($this->handle));

            if ($response === '.') {
                break;
            }

            $lines[] = $response;
        }

        return $lines;
    }

    /**
     * Closes the open file pointer 
     */
    public function __destruct()
    {
        fclose($this->handle);
    }
}
