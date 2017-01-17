<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReader;

/**
 * Obtiene la lista con todas las facturas de tipo crédito fiscal desde la BD
 * filtradas por términos de búsqueda y con limitación según la paginación.
 */
class FilterCreditoFiscal extends MySQLReader
{
    protected $baseQuery = 'SELECT FacturaID, FechaFacturacion, CodigoTiraje, Correlativo, NombreComercial AS NombreCliente, Empleados.Codigo AS CodigoEmpleado, COALESCE(SUM(PrecioUnitario * Cantidad), 0) AS VentaTotal FROM Facturas INNER JOIN TirajeFacturas USING (TirajeFacturaID) INNER JOIN TiposFactura USING (TipoFacturaID) LEFT JOIN DetalleFactura USING (FacturaID) LEFT JOIN Empresas USING (EmpresaID) LEFT JOIN Empleados USING (EmpleadoID) WHERE TipoFacturaID = 2';
    protected $endQuery = 'GROUP BY FacturaID';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'tirajeFactura',
            'tableName' => 'TirajeFacturas',
            'columnName' => 'CodigoTiraje',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'codigoFactura',
            'tableName' => 'Facturas',
            'columnName' => 'Correlativo',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nombresCliente',
            'tableName' => 'Empresas',
            'columnName' => 'NombreComercial',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'codigoEmpleado',
            'tableName' => 'Empleados',
            'columnName' => 'Codigo',
            'searchType' => 'LIKE',
        ],
    ];
}
