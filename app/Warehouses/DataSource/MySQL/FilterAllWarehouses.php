<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

/**
 * Realiza búsquedas filtradas y paginadas de la lista de bodegas.
 */
class FilterAllWarehouses extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT AlmacenID, NombreAlmacen, COALESCE((SELECT SUM(Cantidad) FROM DetalleAlmacenes WHERE DetalleAlmacenes.AlmacenID = Almacenes.AlmacenID), 0) AS Cantidad FROM Almacenes WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'nombreAlmacen',
            'tableName' => 'Almacenes',
            'columnName' => 'NombreAlmacen',
            'searchType' => 'LIKE',
        ],
    ];
}
