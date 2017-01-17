<?php

namespace Sigmalibre\Invoices;

/**
 * Controlador para operaciones sobre créditos fiscales
 */
class CreditosFiscalesController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Renderiza la vista con la lista de las facturas de crédito fical.
     *
     * @param object $request  HTTP Request
     * @param object $response HTTP Response
     *
     * @return object HTTP Response con la vista de las facturas
     */
    public function indexCreditos($request, $response)
    {
        $invoices = new CreditosFiscales($this->container);
        $invoiceList = $invoices->readList($request->getQueryParams());

        return $this->container->view->render($response, 'invoices/creditofiscal.twig', [
            'invoices' => $invoiceList['itemList'],
            'pagination' => $invoiceList['pagination'],
            'input' => $invoiceList['userInput'],
        ]);
    }
}