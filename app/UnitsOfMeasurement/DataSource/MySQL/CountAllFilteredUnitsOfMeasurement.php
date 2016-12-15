<?php

namespace Sigmalibre\UnitsOfMeasurement\DataSource\MySQL;

/**
 * Hace un query en la BD para obtener el conteo de las unidades de medida exitentes.
 */
class CountAllFilteredUnitsOfMeasurement extends FilterAllUnitsOfMeasurement
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM Medidas WHERE 1';
    protected $setLimit = false;
}
