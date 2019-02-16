<?php

namespace Sigmalibre\Reports;

use Sigmalibre\Categories\Categories;
use Sigmalibre\Brands\Brands;
use Sigmalibre\DET\DETReport;
use Sigmalibre\Empleados\Empleados;
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
        $brands = (new Brands($this->container))->readAllBrands();

        return $this->container->view->render($response, 'reports/reports.twig', [
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    public function detPRN(Request $request, Response $response)
    {
        $params = $request->getQueryParams();

        if (empty($params['year']) === true || strlen($params['year']) !== 4) {
            return $response->withRedirect('/reportes');
        }

        $det = new DETReport($this->container);

        return $response
            ->write($det->run($params['year']))
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

        if (empty($params['brand']) === true) {
            return $response->withRedirect('/reportes');
        }

        if (empty($params['orderby']) === true) {
            return $response->withRedirect('/reportes');
        }

        if (!isset($params['columns']) === true) {
            $params['columns'] = [];
        }

        $builder = new ReporteBuilderDirector(new CorteProductosReportBuilder($this->container, $params['category'], $params['brand'], $params['orderby'], $params['columns']));

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

    public function rendimiento(Request $request, Response $response)
    {
        $params = $request->getQueryParams();
        if (empty($params['fecha']) === true) {
            return $response->withRedirect('/reportes');
        }

        $empleados = new Empleados($this->container);
        $rendimiento = $empleados->getRendimiento($params['fecha']);

        $meses = [
            '01' => ['longitud' => 31, 'nombre' => 'Enero'],
            '02' => ['longitud' => 28, 'nombre' => 'Febrero'],
            '03' => ['longitud' => 31, 'nombre' => 'Marzo'],
            '04' => ['longitud' => 30, 'nombre' => 'Abril'],
            '05' => ['longitud' => 31, 'nombre' => 'Mayo'],
            '06' => ['longitud' => 30, 'nombre' => 'Junio'],
            '07' => ['longitud' => 31, 'nombre' => 'Julio'],
            '08' => ['longitud' => 31, 'nombre' => 'Agosto'],
            '09' => ['longitud' => 30, 'nombre' => 'Septiembre'],
            '10' => ['longitud' => 31, 'nombre' => 'Octubre'],
            '11' => ['longitud' => 30, 'nombre' => 'Noviembre'],
            '12' => ['longitud' => 31, 'nombre' => 'Diciembre'],
        ];

        return $this->container->view->render($response, 'reports/rendimiento.twig', [
            'rendimiento' => $rendimiento,
            'dia' => date('d', strtotime($params['fecha'])),
            'mes' => $meses[date('m', strtotime($params['fecha']))],
            'ano' => date('Y', strtotime($params['fecha'])),
        ]);
    }
}
