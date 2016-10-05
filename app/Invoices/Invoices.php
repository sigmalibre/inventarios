<?php

namespace Sigmalibre\Invoices;

class Invoices
{
    private $container;
    private $userInput;
    private $listReader;

    public function __construct($container, $userInput)
    {
        $this->container = $container;
        $this->userInput = $userInput;
        $this->listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllFilteredInvoices($container),
            new DataSource\MySQL\FilterAllInvoices($container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );
    }

    public function readInvoiceList()
    {
        $invoiceList = $this->listReader->read();
        $invoiceList['userInput'] = $this->userInput;

        return $invoiceList;
    }
}
