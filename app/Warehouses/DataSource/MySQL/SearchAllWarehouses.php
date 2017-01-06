<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

/**
 * Realiza una búsqueda de todos los almacenes en existencia.
 */
class SearchAllWarehouses extends FilterAllWarehouses
{
    protected $setLimit = false;
    protected $filterFields = [];
}