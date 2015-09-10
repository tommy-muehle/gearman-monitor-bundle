<?php

namespace EnlightenedDC\GearmanMonitorBundle\Command;

use EnlightenedDC\Gearman\Connection;
use EnlightenedDC\Gearman\Request;
use EnlightenedDC\GearmanMonitorBundle\Report\CliReport;
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
        $job = $input->getArgument('job');

        $servers = $this->getContainer()->getParameter('gearman.servers');
        $cliReport = new CliReport();

        foreach ($servers as $key => $configuration) {
            $connection = new Connection($configuration);
            $response = $connection->send(new Request('status'));

            if (null !== $server) {
                $cliReport->ignoreServer($server);
            }

            if (null !== $job) {
                $cliReport->ignoreJob($job);
            }

            $cliReport->addStates($server, $response);
        }

        $cliReport->render();
    }
}
