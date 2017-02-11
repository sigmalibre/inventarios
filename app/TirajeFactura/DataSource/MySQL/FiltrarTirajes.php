<?php

namespace Sigmalibre\TirajeFactura\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReader;

/**
 * Realiza una búsqueda filtrada según terminos de búsqueda en la BD
 * con capacidad de paginación.
 */
class FiltrarTirajes extends MySQLReader
{
    protected $baseQuery = 'SELECT TirajeFacturaID, CodigoTiraje, TirajeDesde, TirajeHasta, COALESCE(MAX(Correlativo), 0) as MaxCorrelativo FROM TirajeFacturas LEFT JOIN Facturas USING(TirajeFacturaID) WHERE 1';
    protected $endQuery = 'GROUP BY TirajeFacturaID';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'codigoTiraje',
            'tableName' => 'TirajeFacturas',
            'columnName' => 'CodigoTiraje',
            'searchType' => 'LIKE',
        ],
    ];
}
