<?php

namespace Sigmalibre\Invoices;

use Sigmalibre\Invoices\DataSource\MySQL\CountFilteredCreditoFiscal;
use Sigmalibre\Invoices\DataSource\MySQL\FilterCreditoFiscal;
use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\Pagination\Paginator;

/**
 * Modelo para operaciones sobre créditos fiscales.
 */
class CreditosFiscales
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Obtiene una lista con las facturas de tipo crédito fiscal
     * filtradas según los campos de búsqueda y limitada por la paginación.
     *
     * @param array $input Input del usuario con los términos de búsqueda
     *
     * @return array
     */
    public function readList($input)
    {
        $reader = new ItemListReader(
            new CountFilteredCreditoFiscal($this->container),
            new FilterCreditoFiscal($this->container),
            new Paginator($input),
            $input
        );

        $itemList = $reader->read();
        $itemList['userInput'] = $input;

        return $itemList;
    }
}