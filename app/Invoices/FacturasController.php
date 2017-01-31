<?php

namespace Sigmalibre\Invoices;

use Sigmalibre\Invoices\DataSource\MySQL\MySQLFacturaRepository;
use Sigmalibre\TirajeFactura\DataSource\JSON\TirajeActualReader;

/**
 * Controlador para operaciones sobre facturas de consumidor final
 */
class FacturasController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Renderiza la vista con la lista de las facturas de consumidor final.
     *
     * @param object $request  HTTP Request
     * @param object $response HTTP Response
     *
     * @return object HTTP Response con la vista de las facturas
     */
    public function indexFacturas($request, $response)
    {
        $input = $request->getQueryParams();
        $input['tipoFactura'] = (new TirajeActualReader())->getIDTiraje('factura');

        $invoices = new Facturas(new MySQLFacturaRepository($this->container));
        $invoiceList = $invoices->getFiltered($input);

        return $this->container->view->render($response, 'invoices/facturas.twig', [
            'invoices' => $invoiceList['itemList'],
            'pagination' => $invoiceList['pagination'],
            'input' => $input,
        ]);
    }
