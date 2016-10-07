<?php

namespace Sigmalibre\Stores\DataSource\MySQL;

/**
 * Realiza búsquedas filtradas y paginadas de la lista de sucursales.
 */
class FilterAllStores extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT codigo_scr, nombre_scr, direccion_scr, telefono_scr FROM tbsucursales WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'codigoSucursal',
            'tableName' => 'tbsucursales',
            'columnName' => 'codigo_scr',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nombreSucursal',
            'tableName' => 'tbsucursales',
            'columnName' => 'nombre_scr',
            'searchType' => 'LIKE',
        ],
    ];
}
