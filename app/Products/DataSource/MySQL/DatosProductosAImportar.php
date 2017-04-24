<?php

namespace Sigmalibre\Products\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReaderCustomConnection;

/**
 * Lee la lista de datos de productos, exportados desde el programa PowerAcc.
 */
class DatosProductosAImportar extends MySQLReaderCustomConnection
{
    protected $baseQuery = '
    SELECT
        codigo_mas as Codigo,
        precio1_cst as Utilidad
    FROM tbmaster
    LEFT JOIN tbcostos USING (codigo_mas)';
    protected $setLimit = false;
}
