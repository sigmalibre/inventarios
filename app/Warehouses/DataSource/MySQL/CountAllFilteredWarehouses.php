<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

/**
 * Cuenta la cantidad de bodegas que existen en la BD según los términos de búsqueda.
 */
class CountAllFilteredWarehouses extends FilterAllWarehouses
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM Almacenes WHERE 1';
    protected $setLimit = false;
}
