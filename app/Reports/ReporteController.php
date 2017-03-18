<?php

namespace Sigmalibre\Reports;

use Sigmalibre\DET\DETReport;
use Sigmalibre\Reports\ReportBuilders\TestReportBuilder;
use Slim\Http\Request;
use Slim\Http\Response;

class ReporteController
{
    private $loader;
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
        $this->loader = new ReporteLoader($container);
    }

    public function testReporte()
    {
        $builder = new ReporteBuilderDirector(new TestReportBuilder());

        $reporte = $builder->make();

        $reporteRenderizado = $this->loader->render($reporte);

        return (new Response())
            ->withHeader('Content-Type', 'application/pdf')
            ->withHeader('Content-Disposition', 'inline ' . utf8_encode('reporte.pdf'))
            ->withHeader('Cache-Control', 'private, max-age=0, must-revalidate')
            ->write($reporteRenderizado);
    }

    public function index(Request $request, Response $response)
    {
        return $this->container->view->render($response, 'reports/reports.twig');
    }

    public function detPRN(Request $request, Response $response)
    {
        $det = new DETReport($this->container);

        return $response
            ->write($det->run())
            ->withHeader('Content-Disposition', 'attachment; filename="det.txt"')
            ->withHeader('Content-Type', 'text/plain');
    }
}
