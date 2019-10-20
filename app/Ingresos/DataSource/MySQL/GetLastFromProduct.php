<?php

namespace Sigmalibre\Ingresos\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReader;

/**
 * Obtiene el ultimo dato de los ingresos de un producto.
 */
class GetLastFromProduct extends MySQLReader
{
    protected $baseQuery = '
        SELECT
            DetalleIngresosID,
            EmpresaID,
            AlmacenID,
            Cantidad,
            PrecioUnitario
        FROM DetalleIngresos
        WHERE 1';

    protected $endQuery = 'ORDER BY DetalleIngresosID DESC LIMIT 1';

    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'productoID',
            'tableName' => 'DetalleIngresos',
            'columnName' => 'ProductoID',
            'searchType' => '=',
        ]
    ];
}