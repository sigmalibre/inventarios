<?php

namespace Sigmalibre\UnitsOfMeasurement\DataSource\MySQL;

/**
 * Obtiene un solo resultado con la información de una unidad de medida.
 */
class GetUnitFromID extends FilterAllUnitsOfMeasurement
{
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'idMedida',
            'tableName' => 'Medidas',
            'columnName' => 'MedidaID',
            'searchType' => '=',
        ],
    ];
}
