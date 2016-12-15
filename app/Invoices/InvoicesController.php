<?php

namespace Sigmalibre\Invoices;

/**
 * Controlador para las operaciones sobre las facturas.
 */
class InvoicesController
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
    public function indexInvoices($request, $response)
    {
        $invoices = new Invoices($this->container);
        $invoiceList = $invoices->readInvoiceList($request->getQueryParams());

        return $this->container->view->render($response, 'invoices/facturas.html', [
            'invoices' => $invoiceList['itemList'],
            'pagination' => $invoiceList['pagination'],
            'input' => $invoiceList['userInput'],
        ]);
    }

    /**
     * Renderiza la vista con la lista de las facturas de crédito fical.
     *
     * @param object $request  HTTP Request
     * @param object $response HTTP Response
     *
     * @return object HTTP Response con la vista de las facturas
     */
    public function indexCreditoFiscal($request, $response)
    {
        $invoices = new Invoices($this->container);
        $invoiceList = $invoices->readCreditoFiscalList($request->getQueryParams());

        return $this->container->view->render($response, 'invoices/creditofiscal.html', [
            'invoices' => $invoiceList['itemList'],
            'pagination' => $invoiceList['pagination'],
            'input' => $invoiceList['userInput'],
        ]);
    }
}
