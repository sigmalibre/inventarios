<?php

namespace Sigmalibre\UnitsOfMeasurement\DataSource\MySQL;

class CountAllFilteredUnitsOfMeasurement extends FilterAllUnitsOfMeasurement
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM Medidas WHERE 1';
    protected $setLimit = false;
}
