<?php

namespace Sigmalibre\Reports;

use Sigmalibre\Categories\Categories;
use Sigmalibre\DET\DETReport;
use Sigmalibre\Reports\ReportBuilders\CorteProductosReportBuilder;
use Sigmalibre\Reports\ReportBuilders\ResumenMercaderiaReportBuilder;
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
        $categories = (new Categories($this->container))->readAllCategories();

        return $this->container->view->render($response, 'reports/reports.twig', [
            'categories' => $categories,
        ]);
    }

    public function detPRN(Request $request, Response $response)
    {
        $det = new DETReport($this->container);

        return $response
            ->write($det->run())
            ->withHeader('Content-Disposition', 'attachment; filename="det.txt"')
            ->withHeader('Content-Type', 'text/plain');
    }

    public function conteoInventario(Request $request, Response $response)
    {
        $loader = new ReporteLoader($this->container, 'conteoreport.twig', 'landscape');

        $params = $request->getQueryParams();

        if (empty($params['category']) === true) {
            return $response->withRedirect('/reportes');
        }

        if (empty($params['orderby']) === true) {
            return $response->withRedirect('/reportes');
        }

        $builder = new ReporteBuilderDirector(new CorteProductosReportBuilder($this->container, $params['category'], $params['orderby']));

        $reporte = $builder->make();

        $reporteRenderizado = $loader->render($reporte);

        return (new Response())
            ->withHeader('Content-Type', 'application/pdf')
            ->withHeader('Content-Disposition', 'inline ' . utf8_encode('reporte.pdf'))
            ->withHeader('Cache-Control', 'private, max-age=0, must-revalidate')
            ->write($reporteRenderizado);
    }

    public function resumenExistencia()
    {
        $builder = new ReporteBuilderDirector(new ResumenMercaderiaReportBuilder($this->container));

        $reporte = $builder->make();

        $reporteRenderizado = $this->loader->render($reporte);

        return (new Response())
            ->withHeader('Content-Type', 'application/pdf')
            ->withHeader('Content-Disposition', 'inline ' . utf8_encode('reporte.pdf'))
            ->withHeader('Cache-Control', 'private, max-age=0, must-revalidate')
            ->write($reporteRenderizado);
    }
}
