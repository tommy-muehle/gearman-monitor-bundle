<?php

namespace EnlightenedDC\GearmanMonitorBundle\Command;

use EnlightenedDC\GearmanMonitorBundle\Model\Status;
use EnlightenedDC\GearmanMonitorBundle\Service\Monitor;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MonitorCommand
 * @package EnlightenedDC\GearmanMonitorBundle\Command
 */
class MonitorCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('gearman:monitor')
            ->addArgument('server', InputArgument::OPTIONAL, 'The name for the server. (such as "localhost")', null)
            ->addArgument('job', InputArgument::OPTIONAL, 'A job name to filter. (such as "reverse")', null)
            ->setDescription('Displays an overview about gearman job status.')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command displays an overview about gearman status:

  <info>php %command.full_name%</info>
  <comment>Shows all job status for all servers.</comment>

You can also set a server- and job-name to filter the output:

  <info>php %command.full_name% localhost</info>
  <comment>Displays all jobs status on server "localhost".</comment>

  <info>php %command.full_name% localhost my-job-name</info>
  <comment>Displays only the job status for "my-job-name" on server "localhost".</comment>

EOF
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = $input->getArgument('server');
        $servers = $this->getContainer()->getParameter('gearman.servers');

        foreach ($servers as $key => $configuration) {
            if (null !== $server && $key !== $server) {
                continue;
            }

            $output->writeln(sprintf('<info>Server: %s</info>', $key));
            $monitor = new Monitor($configuration['host'], $configuration['port']);

            $table = $this->getTable($monitor->getStatusData($input->getArgument('job')));
            $table->render($output);
        }
    }

    /**
     * @param Status[] $statusData
     *
     * @return \Symfony\Component\Console\Helper\TableHelper
     */
    protected function getTable(array $statusData)
    {
        /* @var $table \Symfony\Component\Console\Helper\TableHelper */
        $table = $this->getHelper('table');
        $table->setHeaders(['Job name', 'Available workers', 'Total jobs', 'Running jobs']);

        foreach ($statusData as $status) {
            $table->addRow([
                $status->getJobName(),
                $status->getAvailableWorkers(),
                $status->getQueuedJobs(),
                $status->getRunningJobs()
            ]);
        }

        return $table;
    }
}
