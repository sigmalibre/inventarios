<?php

namespace Sigmalibre\Cotizaciones;

use Sigmalibre\Brands\Brands;
use Sigmalibre\Categories\Categories;
use Sigmalibre\IVA\IVA;
use Sigmalibre\Reports\ReportBuilders\CotizacionReportBuilder;
use Sigmalibre\Reports\ReporteBuilderDirector;
use Sigmalibre\Reports\ReporteLoader;
use Slim\Http\Request;
use Slim\Http\Response;

class CotizacionController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response)
    {
        $iva = new IVA();
        $categorias = new Categories($this->container);
        $marcas = new Brands($this->container);

        return $this->container->view->render($response, 'invoices/nuevafactura.twig', [
            'titulo' => 'Nueva Cotización',
            'tipoFactura' => 3,
            'nextCorrelativo' => 1,
            'iva' => $iva->getPorcentajeIVA(),
            'categories' => $categorias->readAllCategories(),
            'brands' => $marcas->readAllBrands(),
            'readOnly' => 0,
        ]);
    }

    public function report(Request $request)
    {
        $loader = new ReporteLoader($this->container);

        $builder = new ReporteBuilderDirector(new CotizacionReportBuilder($request->getParsedBody()));

        $reporteRenderizado = $loader->render($builder->make());

        return (new Response())
            ->withHeader('Content-Type', 'application/pdf')
            ->withHeader('Content-Disposition', 'inline ' . utf8_encode('reporte.pdf'))
            ->withHeader('Cache-Control', 'private, max-age=0, must-revalidate')
            ->write($reporteRenderizado);
    }
}
