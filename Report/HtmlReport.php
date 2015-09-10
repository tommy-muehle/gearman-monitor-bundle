<?php

namespace EnlightenedDC\GearmanMonitorBundle\Report;

/**
 * Class HtmlReport
 *
 * @package EnlightenedDC\GearmanMonitorBundle\Report
 */
class HtmlReport extends AbstractReport
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->twig->render(
            realpath(__DIR__ . '/../Resources/views/monitor.html.twig'),
            ['states' => $this->states]
        );
    }
}
