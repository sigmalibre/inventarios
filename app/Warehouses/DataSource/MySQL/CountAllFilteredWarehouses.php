<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

/**
 * Cuenta la cantidad de bodegas que existen en la BD según los términos de búsqueda.
 */
class CountAllFilteredWarehouses extends FilterAllWarehouses
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM (SELECT 1 FROM Almacenes LEFT JOIN DetalleAlmacenes USING (AlmacenID) WHERE 1';
    protected $endQuery = 'GROUP BY AlmacenID) AS tmp';
    protected $setLimit = false;
}
