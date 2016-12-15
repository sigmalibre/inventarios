<?php

namespace Sigmalibre\Invoices;

/**
 * Modelo para operaciones sobre las facturas.
 */
class Invoices
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Obtiene una lista con las facturas de consumidor final
     * filtradas según los campos de búsqueda y limitada por la paginación.
     *
     * @param array $userInput Input del usuario con los términos de búsqueda
     *
     * @return array
     */
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

    /**
     * Obtiene una lista con las facturas de tipo crédito fiscal
     * filtradas según los campos de búsqueda y limitada por la paginación.
     *
     * @param array $userInput Input del usuario con los términos de búsqueda
     *
     * @return array
     */
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
