<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

/**
 * Realiza búsquedas filtradas y paginadas de la lista de bodegas.
 */
class FilterAllWarehouses extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT codigo_bod, nombre_bod, encargado_bod, direccion_bod FROM tbbodegas WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'codigoBodega',
            'tableName' => 'tbbodegas',
            'columnName' => 'codigo_bod',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nombreBodega',
            'tableName' => 'tbbodegas',
            'columnName' => 'nombre_bod',
            'searchType' => 'LIKE',
        ],
    ];
}
