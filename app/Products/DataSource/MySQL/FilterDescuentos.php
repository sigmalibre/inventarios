<?php

namespace Sigmalibre\Products\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReader;

/**
 * Obtiene todos los desuentos asociados a un producto.
 */
class FilterDescuentos extends MySQLReader
{
    protected $baseQuery = 'SELECT DescuentoID, RazonDescuento, CantidadDescontada, ProductoID FROM Descuentos WHERE 1';
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'productoID',
            'tableName' => 'Descuentos',
            'columnName' => 'ProductoID',
            'searchType' => '=',
        ],
    ];
}