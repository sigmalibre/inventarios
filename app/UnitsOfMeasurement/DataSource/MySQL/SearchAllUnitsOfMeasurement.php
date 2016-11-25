<?php

namespace Sigmalibre\UnitsOfMeasurement\DataSource\MySQL;

class SearchAllUnitsOfMeasurement extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT MedidaID, UnidadMedida FROM Medidas';
    protected $setLimit = false;
}
