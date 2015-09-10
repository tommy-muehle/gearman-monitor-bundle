<?php

namespace EnlightenedDC\GearmanMonitorBundle\Controller;

use EnlightenedDC\Gearman\Connection;
use EnlightenedDC\Gearman\Request;
use EnlightenedDC\GearmanMonitorBundle\Report\HtmlReport;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MonitorController
 *
 * @package EnlightenedDC\GearmanMonitorBundle\Controller
 */
class MonitorController extends Controller
{
    /**
     * @return string
     * @throws \EnlightenedDC\Gearman\Exception\GearmanConnectionException
     */
    public function indexAction()
    {
        $report = new HtmlReport($this->get('twig'));
        $servers = $this->container->getParameter('gearman.servers');

        foreach ($servers as $key => $configuration) {
            $connection = new Connection($configuration);
            $response = $connection->send(new Request('status'));

            $report->addStates($key, $response);
        }

        return $report->render();
    }
}
