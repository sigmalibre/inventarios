<?php

namespace Sigmalibre\TirajeFactura\DataSource\MySQL;

/**
 * Obtiene la informaición sobre un tiraje específico desde la BD.
 */
class TirajeDesdeID extends FiltrarTirajes
{
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'idTiraje',
            'tableName' => 'TirajeFacturas',
            'columnName' => 'TirajeFacturaID',
            'searchType' => '=',
        ],
    ];
}
