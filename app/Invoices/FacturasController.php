<?php

namespace Sigmalibre\Invoices;

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
        $invoices = new Facturas($this->container);
        $invoiceList = $invoices->readList($request->getQueryParams());

        return $this->container->view->render($response, 'invoices/facturas.twig', [
            'invoices' => $invoiceList['itemList'],
            'pagination' => $invoiceList['pagination'],
            'input' => $invoiceList['userInput'],
        ]);
    }
}