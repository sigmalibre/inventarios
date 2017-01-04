<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

/**
 * Obtiene la información sobre un almacen desde su ID.
 */
class GetWarehouseFromID extends FilterAllWarehouses
{
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'idAlmacen',
            'tableName' => 'Almacenes',
            'columnName' => 'AlmacenID',
            'searchType' => '=',
        ],
    ];
}