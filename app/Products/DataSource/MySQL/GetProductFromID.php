<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Obtiene un solo resultado con la información de un producto según su ID.
 */
class GetProductFromID extends FilterAllProducts
{
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'idProducto',
            'tableName' => 'Productos',
            'columnName' => 'ProductoID',
            'searchType' => '=',
        ],
    ];
    protected $endQuery = 'GROUP BY ProductoID';
}
