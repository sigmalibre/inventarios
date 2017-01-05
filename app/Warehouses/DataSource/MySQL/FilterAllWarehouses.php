<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

/**
 * Realiza búsquedas filtradas y paginadas de la lista de bodegas.
 */
class FilterAllWarehouses extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT AlmacenID, NombreAlmacen, COALESCE(SUM(Cantidad), 0) AS Cantidad FROM Almacenes LEFT JOIN DetalleAlmacenes USING (AlmacenID) WHERE 1';
    protected $endQuery = 'GROUP BY AlmacenID';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'nombreAlmacen',
            'tableName' => 'Almacenes',
            'columnName' => 'NombreAlmacen',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'productoID',
            'tableName' => 'DetalleAlmacenes',
            'columnName' => 'ProductoID',
            'searchType' => '=',
        ],
    ];
}
