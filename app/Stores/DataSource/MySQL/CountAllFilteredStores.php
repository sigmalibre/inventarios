<?php

namespace Sigmalibre\Stores\DataSource\MySQL;

/**
 * Cuenta la cantidad de sucursales que existen en la BD según los términos de búsqueda.
 */
class CountAllFilteredStores extends FilterAllStores
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM tbsucursales WHERE 1';
    protected $setLimit = false;
}
