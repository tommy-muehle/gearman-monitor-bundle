<?php

namespace EnlightenedDC\GearmanMonitorBundle\Report;

use EnlightenedDC\GearmanMonitorBundle\Gearman\State;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class CliReport
 *
 * @package EnlightenedDC\GearmanMonitorBundle\Report
 */
class CliReport extends AbstractReport
{
    /**
     * @var ConsoleOutput
     */
    private $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    /**
     * @return string
     */
    public function render()
    {
        /* @var $state State */
        foreach ($this->states as $key => $state) {
            $this->output->writeln(sprintf('<info>%s</info>', $key));

            $table = new TableHelper();
            $table->setHeaders(['Job name', 'Available workers', 'Total jobs', 'Running jobs']);
            $table->addRow([
                $state->getJobName(),
                $state->getAvailableWorkers(),
                $state->getQueuedJobs(),
                $state->getRunningJobs()
            ]);

            $table->render($this->output);
        }
    }
}
