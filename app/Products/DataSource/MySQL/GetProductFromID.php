<?php

namespace Sigmalibre\Products\DataSource\MySQL;

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
}
