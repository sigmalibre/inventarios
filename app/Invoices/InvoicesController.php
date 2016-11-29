<?php

namespace Sigmalibre\Invoices;

class InvoicesController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

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
