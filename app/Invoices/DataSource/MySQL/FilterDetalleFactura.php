<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReaderCustomConnection;

class FilterDetalleFactura extends MySQLReaderCustomConnection
{
    protected $baseQuery = 'SELECT DetalleFacutaID, Cantidad, PrecioUnitario, ProductoID, FacturaID FROM DetalleFactura WHERE 1';
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'id',
            'tableName' => 'DetalleFactura',
            'columnName' => 'DetalleFacutaID',
            'searchType' => '=',
        ],
        [
            'filterName' => 'productoID',
            'tableName' => 'DetalleFactura',
            'columnName' => 'ProductoID',
            'searchType' => '=',
        ],
        [
            'filterName' => 'facturaID',
            'tableName' => 'DetalleFactura',
            'columnName' => 'FacturaID',
            'searchType' => '=',
        ],
    ];
}