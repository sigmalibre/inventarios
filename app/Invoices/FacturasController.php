<?php

namespace Sigmalibre\Invoices;

use Psr\Http\Message\ResponseInterface;
use Sigmalibre\Clients\Clients;
use Sigmalibre\Empresas\Empresa;
use Sigmalibre\Empresas\Empresas;
use Sigmalibre\Invoices\DataSource\MySQL\MySQLFacturaRepository;
use Sigmalibre\TirajeFactura\DataSource\JSON\TirajeActualReader;
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
        $this->tirajeID = (new TirajeActualReader())->getIDTiraje('factura');
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

    {

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
        $empresa = new Empresa((new TirajeActualReader())->getIDTiraje('empresa'), $this->container);

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
        ]);
    }
}
