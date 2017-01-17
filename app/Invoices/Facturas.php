<?php

namespace Sigmalibre\Invoices;

use Sigmalibre\Invoices\DataSource\MySQL\CountFilteredFacturas;
use Sigmalibre\Invoices\DataSource\MySQL\FilterFacturas;
use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\Pagination\Paginator;

/**
 * Modelo para operaciones sobre facturas de consumidor final.
 */
class Facturas
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
     * @param array $input Input del usuario con los términos de búsqueda
     *
     * @return array
     */
    public function readList($input)
    {
        $reader = new ItemListReader(
            new CountFilteredFacturas($this->container),
            new FilterFacturas($this->container),
            new Paginator($input),
            $input
        );

        $itemList = $reader->read();
        $itemList['userInput'] = $input;

        return $itemList;
    }
}