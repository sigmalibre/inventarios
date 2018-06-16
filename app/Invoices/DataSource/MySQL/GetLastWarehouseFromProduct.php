<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReader;

class GetLastWarehouseFromProduct extends MySQLReader
{
    protected $baseQuery = '
        SELECT AlmacenID
        FROM DetalleFactura
        WHERE 1';
    protected $setLimit = false;
    protected $endQuery = 'ORDER BY DetalleFacutaID DESC LIMIT 1';
    protected $filterFields = [
        [
            'filterName' => 'productoID',
            'tableName' => 'DetalleFactura',
            'columnName' => 'ProductoID',
            'searchType' => '=',
        ]
    ];
}