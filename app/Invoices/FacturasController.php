<?php

namespace Sigmalibre\Invoices;

use Psr\Http\Message\ResponseInterface;
use Sigmalibre\Brands\Brands;
use Sigmalibre\Categories\Categories;
use Sigmalibre\Clients\Clients;
use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\Empresas\Empresa;
use Sigmalibre\Empresas\Empresas;
use Sigmalibre\Empleados\Empleados;
use Sigmalibre\Ingresos\Ingresos;
use Sigmalibre\Invoices\DataSource\MySQL\MySQLFacturaRepository;
use Sigmalibre\IVA\IVA;
use Sigmalibre\UserConfig\ConfigReader;
use Sigmalibre\TirajeFactura\SiguienteCorrelativo;
use Sigmalibre\TirajeFactura\TirajeFactura;
use Sigmalibre\Warehouses\Warehouses;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Controlador para operaciones sobre facturas de consumidor final
 */
class FacturasController
{
    protected $container;
    protected $tirajeID;
    protected $tipoFacturaID;
    protected $listViewFileName = 'invoices/facturas.twig';

    public function __construct($container)
    {
        $this->container = $container;
        $this->tirajeID = (new ConfigReader())->read('factura');
        $this->tipoFacturaID = 1;
    }

    /**
     * Renderiza la vista con la lista de las facturas de consumidor final.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return object HTTP Response con la vista de las facturas
     */
    public function indexFacturas(Request $request, ResponseInterface $response)
    {
        $input = $request->getQueryParams();
        $input['tipoFactura'] = $this->tipoFacturaID;

        $invoices = new Facturas(new MySQLFacturaRepository($this->container), $this->container);
        $invoiceList = $invoices->getFiltered($input);

        return $this->container->view->render($response, $this->listViewFileName, [
            'invoices' => $invoiceList['itemList'],
            'pagination' => $invoiceList['pagination'],
            'input' => $input,
        ]);
    }

    /**
     * Obtiene el input del usuario y crea una factura nueva.
     *
     * @param \Slim\Http\Request  $request
     *
     * @param \Slim\Http\Response $response
     *
     * @return \Slim\Http\Response
     */
    public function saveNew(Request $request, Response $response)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $correlativo = new SiguienteCorrelativo(new TirajeFactura($this->tirajeID, $this->container));

        $input = $request->getParsedBody();
        $input['tipoFacturaID'] = $this->tipoFacturaID;
        $input['tirajeFacturaID'] = $this->tirajeID;
        $input['correlativo'] = $input['correlativo'] ?? $correlativo->getNext();
        $input['empleadoID'] = empty($input['empleadoID']) ? null : $input['empleadoID'];
        $input['empresaID'] = empty($input['empresaID']) ? null : $input['empresaID'];
        $input['clientePersonaID'] = empty($input['clienteID']) ? null : $input['clienteID'];

        $input['detalles'] = array_map(function ($detalle) {
            $d = [
                'almacenID' => $detalle['almacenID'] ?? null,
                'cantidad' => (int)$detalle['cantidad'] ?? null,
                'precio' => (float)$detalle['precio'] ?? null,
                'productoID' => $detalle['id'] ?? null,
            ];

            return $d;
        }, $input['detalles'] ?? []);

        $facturasManager = new Facturas(new MySQLFacturaRepository($this->container), $this->container);

        $isSaved = $facturasManager->newFactura($input);
        $failedInput = $facturasManager->getInvalidInput();

        if ($isSaved === true) {
            return (new Response())->withJson([
                'status' => 'success',
            ], 200);
        }

        return (new Response())->withJson([
            'status' => 'error',
            'reason' => $failedInput,
        ], 200);
    }

    /**
     * Renderiza la vista del formulario de una factura nueva.
     *
     * @return \Slim\Http\Response
     */
    public function indexNew($request, $response, $arguments)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        if ($this->container->negotiator->getValue() === 'application/json') {
            return $this->indexSingle($arguments['id']);
        }

        $tiraje = new TirajeFactura($this->tirajeID, $this->container);
        $correlativo = new SiguienteCorrelativo($tiraje);
        $clientes = new Clients($this->container);
        $empresas = new Empresas($this->container);
        $empleados = new Empleados($this->container);
        $empresa = new Empresa((new ConfigReader())->read('empresa'), $this->container);
        $iva = new IVA();
        $categorias = new Categories($this->container);
        $marcas = new Brands($this->container);

        $readOnly = 0;

        if (isset($arguments['id']) === true) {
            $readOnly = 1;
        }

        return $this->container->view->render($response, 'invoices/nuevafactura.twig', [
            'empresa' => [
                'nombre' => $empresa->getNombre(),
                'giro' => $empresa->getGiro(),
                'direccion' => $empresa->getDireccion(),
                'telefono' => $empresa->getTelefono(),
                'registro' => $empresa->getRegistro(),
                'nit' => $empresa->getNit(),
            ],
            'facturaID' => $arguments['id'] ?? null,
            'codigoTiraje' => $tiraje->CodigoTiraje,
            'tipoFactura' => $this->tipoFacturaID,
            'tirajeFacturaID' => $this->tirajeID,
            'nextCorrelativo' => $correlativo->getNext(),
            'minCorrelativo' => $tiraje->TirajeDesde,
            'maxCorrelativo' => $tiraje->TirajeHasta,
            'clientes' => $clientes->getAllClients(),
            'contribuyentes' => $empresas->getAll(),
            'empleados' => $empleados->getAll(),
            'iva' => $iva->getPorcentajeIVA(),
            'categories' => $categorias->readAllCategories(),
            'brands' => $marcas->readAllBrands(),
            'readOnly' => $readOnly,
        ]);
    }

    private function indexSingle($id)
    {
        $facturas = new MySQLFacturaRepository($this->container);
        $almacenes = new Warehouses($this->container);

        $factura = $facturas->findByID($id);

        if ($factura !== false) {
            return (new Response())->withJson([
                'factura' => $factura,
                'almacenes' => $almacenes->readAll(),
            ], 200);
        }

        return (new Response())->withJson([
            'status' => 'error',
            'reason' => 'not found',
        ], 200);
    }

    public function delete($request, $response, $arguments)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $id = $arguments['id'];

        $facturas = new MySQLFacturaRepository($this->container);

        $factura = $facturas->findByID($id);

        if ($factura === false) {
            return (new Response())->withJson([
                'status' => 'error',
                'reason' => 'not found',
            ], 200);
        }

        /** @var MySQLTransactions $transaction */
        $transaction = $this->container->mysql;

        $transaction->beginTransaction();

        foreach ($factura->detalles as $detalle) {

            $ingresos = new Ingresos($this->container);

            $isSaved = $ingresos->save([
                'cantidadIngreso' => $detalle->cantidad,
                'valorPrecioUnitario' => $detalle->producto->CostoActual,
                'valorCostoActualTotal' => $detalle->producto->CostoActual,
                'productoID' => $detalle->producto->ProductoID,
                'empresaID' => null,
                'almacenID' => $detalle->almacenID,
            ], $detalle->producto->ProductoID);

            if ($isSaved === false) {
                $transaction->rollBack();

                return (new Response())->withJson([
                    'status' => 'error',
                    'reason' => 'detail-not-deleted',
                ], 200);
            }
        }

        $isDeleted = $facturas->remove($factura);
        if ($isDeleted === false) {
            $transaction->rollBack();

            return (new Response())->withJson([
                'status' => 'error',
                'reason' => 'factura-not-deleted',
            ], 200);
        }

        $transaction->commit();

        return (new Response())->withJson([
            'status' => 'success',
        ], 200);
    }

    public function ultimoWarehouse(Request $request, ResponseInterface $response, $arguments)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $facturas = new MySQLFacturaRepository($this->container);

        $ultimo = $facturas->getLastWarehouse($arguments['id']);

        if(!isset($ultimo[0])) {
            return (new Response())->withJson([ 'success' => false ], 200);
        }

        $ultimo = $ultimo[0];

        return (new Response())->withJson([ 'success' => true, 'ultimo' => $ultimo ], 200);
    }
}
