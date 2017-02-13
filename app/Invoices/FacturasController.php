<?php

namespace Sigmalibre\Invoices;

use Psr\Http\Message\ResponseInterface;
use Sigmalibre\Clients\Clients;
use Sigmalibre\Empresas\Empresa;
use Sigmalibre\Empresas\Empresas;
use Sigmalibre\Invoices\DataSource\MySQL\MySQLFacturaRepository;
use Sigmalibre\IVA\IVA;
use Sigmalibre\DataSource\JSON\ConfigReader;
use Sigmalibre\TirajeFactura\SiguienteCorrelativo;
use Sigmalibre\TirajeFactura\TirajeFactura;
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
        $input['tipoFactura'] = $this->tirajeID;

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
     * @param \Slim\Http\Request $request
     *
     * @return \Slim\Http\Response
     */
    public function saveNew(Request $request)
    {
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
    public function indexNew()
    {
        $tiraje = new TirajeFactura($this->tirajeID, $this->container);
        $correlativo = new SiguienteCorrelativo($tiraje);
        $clientes = new Clients($this->container);
        $empresas = new Empresas($this->container);
        $empresa = new Empresa((new ConfigReader())->read('empresa'), $this->container);
        $iva = new IVA();

        return $this->container->view->render(new Response(), 'invoices/nuevafactura.twig', [
            'empresa' => [
                'nombre' => $empresa->getNombre(),
                'giro' => $empresa->getGiro(),
                'direccion' => $empresa->getDireccion(),
                'telefono' => $empresa->getTelefono(),
                'registro' => $empresa->getRegistro(),
                'nit' => $empresa->getNit(),
            ],
            'codigoTiraje' => $tiraje->CodigoTiraje,
            'tipoFactura' => $this->tipoFacturaID,
            'tirajeFacturaID' => $this->tirajeID,
            'nextCorrelativo' => $correlativo->getNext(),
            'minCorrelativo' => $tiraje->TirajeDesde,
            'maxCorrelativo' => $tiraje->TirajeHasta,
            'clientes' => $clientes->getAllClients(),
            'contribuyentes' => $empresas->getAll(),
            'iva' => $iva->getPorcentajeIVA(),
        ]);
    }
}
