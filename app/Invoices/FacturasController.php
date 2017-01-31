<?php

namespace Sigmalibre\Invoices;

use Psr\Http\Message\ResponseInterface;
use Sigmalibre\Invoices\DataSource\MySQL\MySQLFacturaRepository;
use Sigmalibre\TirajeFactura\DataSource\JSON\TirajeActualReader;
use Slim\Http\Request;

/**
 * Controlador para operaciones sobre facturas de consumidor final
 */
class FacturasController
{
    protected $container;
    protected $tirajeID;
    protected $listViewFileName = 'invoices/facturas.twig';

    public function __construct($container)
    {
        $this->container = $container;
        $this->tirajeID = (new TirajeActualReader())->getIDTiraje('factura');
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

        $invoices = new Facturas(new MySQLFacturaRepository($this->container));
        $invoiceList = $invoices->getFiltered($input);

        return $this->container->view->render($response, $this->listViewFileName, [
            'invoices' => $invoiceList['itemList'],
            'pagination' => $invoiceList['pagination'],
            'input' => $input,
        ]);
    }
