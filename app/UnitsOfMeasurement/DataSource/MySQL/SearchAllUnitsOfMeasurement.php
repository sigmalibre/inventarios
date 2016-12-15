<?php

namespace Sigmalibre\UnitsOfMeasurement\DataSource\MySQL;

/**
 * Realiza un query en la BD para obtener la lista completa de todos las unidades de medida existentes.
 */
class SearchAllUnitsOfMeasurement extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT MedidaID, UnidadMedida FROM Medidas';
    protected $setLimit = false;
}
