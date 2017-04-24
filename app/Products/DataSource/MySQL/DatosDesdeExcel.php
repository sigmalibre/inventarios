<?php

namespace Sigmalibre\Products\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReaderCustomConnection;

class DatosDesdeExcel extends MySQLReaderCustomConnection
{
    protected $baseQuery = '
      SELECT
        Codigo,
        Categoria,
        Medida,
        Descripcion,
        Marca,
        Unidades,
        Costo
      FROM Productos';
    protected $setLimit = false;
}
