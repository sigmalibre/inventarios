<?php

namespace Sigmalibre\Reports;

use Sigmalibre\Reports\ReportBuilders\TestReportBuilder;
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
}
