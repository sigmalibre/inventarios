<?php

namespace Sigmalibre\Invoices;

class Invoices
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function readInvoiceList($userInput)
    {
        $listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountFilteredFacturas($this->container),
            new DataSource\MySQL\FilterFacturas($this->container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );

        $invoiceList = $listReader->read();
        $invoiceList['userInput'] = $userInput;

        return $invoiceList;
    }

    public function readCreditoFiscalList($userInput)
    {
        $listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountFilteredCreditoFiscal($this->container),
            new DataSource\MySQL\FilterCreditoFiscal($this->container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );

        $invoiceList = $listReader->read();
        $invoiceList['userInput'] = $userInput;

        return $invoiceList;
    }
}
