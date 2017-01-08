<?php

namespace Sigmalibre\Ingresos\DataSource\MySQL;

/**
 * Obtiene información sobre un detalle de ingreso de producto buscado según su ID.
 */
class GetIngresoFromID extends FilterIngresos
{
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'idIngreso',
            'tableName' => 'DetalleIngresos',
            'columnName' => 'DetalleIngresosID',
            'searchType' => '=',
        ],
    ];
}