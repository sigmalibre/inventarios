<?php

namespace Sigmalibre\UnitsOfMeasurement\DataSource\MySQL;

/**
 * Realiza un query en la BD para obtener una lista con todas las unidades de medida
 * Según los términos de búsqueda que aplique el usuario y limitado por la paginación.
 */
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
