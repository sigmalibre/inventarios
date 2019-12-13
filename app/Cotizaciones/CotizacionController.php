<?php

namespace Sigmalibre\Cotizaciones;

use Psr\Http\Message\ResponseInterface;
use Sigmalibre\Brands\Brands;
use Sigmalibre\Categories\Categories;
use Sigmalibre\Clients\Clients;
use Sigmalibre\Empresas\Empresa;
use Sigmalibre\Empresas\Empresas;
use Sigmalibre\Empleados\Empleados;
use Sigmalibre\IVA\IVA;
use Sigmalibre\UserConfig\ConfigReader;
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
        $clientes = new Clients($this->container);
        $empresas = new Empresas($this->container);
        $empleados = new Empleados($this->container);
        $empresa = new Empresa((new ConfigReader())->read('empresa'), $this->container);
        $iva = new IVA();
        $categorias = new Categories($this->container);
        $marcas = new Brands($this->container);

        return $this->container->view->render($response, 'invoices/nuevafactura.twig', [
            'empresa' => [
                'nombre' => $empresa->getNombre(),
                'giro' => $empresa->getGiro(),
                'direccion' => $empresa->getDireccion(),
                'telefono' => $empresa->getTelefono(),
                'registro' => $empresa->getRegistro(),
                'nit' => $empresa->getNit(),
            ],
            'titulo' => 'Nueva Cotización',
            'tipoFactura' => 3,
            'nextCorrelativo' => 1,
            'clientes' => $clientes->getAllClients(),
            'contribuyentes' => $empresas->getAll(),
            'empleados' => $empleados->getAll(),
            'iva' => $iva->getPorcentajeIVA(),
            'categories' => $categorias->readAllCategories(),
            'brands' => $marcas->readAllBrands(),
            'readOnly' => 0,
        ]);
    }

    public function report(Request $request)
    {
        $loader = new ReporteLoader($this->container);

        $body = $request->getParsedBody();

        if (empty($body['dontsave'])) {
            $cotizaciones = new Cotizaciones($this->container);
            $cotizaciones->save([
                "datos" => json_encode($body['detalles']),
                "cliente" => empty($body['clienteID']) ? null : (int) $body['clienteID'],
                "empleado" => empty($body['empleadoID']) ? null : (int) $body['empleadoID'],
            ]);
        }

        $builder = new ReporteBuilderDirector(new CotizacionReportBuilder($body['detalles']));

        $reporteRenderizado = $loader->render($builder->make());

        return (new Response())
            ->withHeader('Content-Type', 'application/pdf')
            ->withHeader('Content-Disposition', 'inline ' . utf8_encode('reporte.pdf'))
            ->withHeader('Cache-Control', 'private, max-age=0, must-revalidate')
            ->write($reporteRenderizado);
    }

    public function indexCotizaciones(Request $request, ResponseInterface $response) {
        $cotizaciones = new Cotizaciones($this->container);
        $list = $cotizaciones->readAllCotizaciones();

        return $this->container->view->render($response, 'invoices/cotizaciones.twig', [
            'cotizaciones' => $list,
            'datos' => str_replace('\\"', '\\\\"', json_encode($list)),
        ]);
    }

    public function delete(Request $request, ResponseInterface $response, $arguments)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $cotizaciones = new Cotizaciones($this->container);
        $eliminada = $cotizaciones->delete($arguments['id']);

        return (new Response())->withJson([
            'status' => $eliminada ? 'success' : 'error',
            'id' => $arguments['id'],
        ], 200);
    }
}
