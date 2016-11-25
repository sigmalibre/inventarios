<?php

namespace Sigmalibre\UnitsOfMeasurement\DataSource\MySQL;

class FilterAllUnitsOfMeasurement extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT MedidaID, UnidadMedida FROM Medidas WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'nombreMedida',
            'tableName' => 'Medidas',
            'columnName' => 'UnidadMedida',
            'searchType' => 'LIKE',
        ],
    ];
}
