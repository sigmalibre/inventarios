<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReader;

/**
 * Obtiene datos sobre los detalles de la cantidad de producto en una bodega.
 */
class FilterWarehouseDetails extends MySQLReader
{
    protected $baseQuery = 'SELECT DetalleAlmacenesID, Cantidad, AlmacenID, NombreAlmacen, ProductoID FROM DetalleAlmacenes INNER JOIN Almacenes USING (AlmacenID) WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'almacenID',
            'tableName' => 'DetalleAlmacenes',
            'columnName' => 'AlmacenID',
            'searchType' => '=',
        ],
        [
            'filterName' => 'productoID',
            'tableName' => 'DetalleAlmacenes',
            'columnName' => 'ProductoID',
            'searchType' => '=',
        ],
    ];
}