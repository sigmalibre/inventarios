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
        $parameters = $request->getQueryParams();

        $invoices = new Invoices($this->container, $parameters);
        $invoiceList = $invoices->readInvoiceList();

        return $this->container->view->render($response, 'invoices.html', [
            'invoices' => $invoiceList['itemList'],
            'pagination' => $invoiceList['pagination'],
            'input' => $invoiceList['userInput'],
        ]);
    }
}
