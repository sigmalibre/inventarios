<?php

namespace Sigmalibre\TirajeFactura\DataSource\MySQL;

/**
 * Realiza una búsqueda filtrada según terminos de búsqueda en la BD
 * con capacidad de paginación.
 */
class FiltrarTirajes extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT TirajeFacturaID, CodigoTiraje, TirajeDesde, TirajeHasta, MAX(Correlativo) as MaxCorrelativo FROM TirajeFacturas LEFT JOIN Facturas USING(TirajeFacturaID) WHERE 1';
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
