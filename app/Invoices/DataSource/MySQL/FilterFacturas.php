<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

/**
 * Obtiene la lista con todas las facturas de tipo consumidor final desde la BD
 * filtradas por términos de búsqueda y con limitación según la paginación.
 */
class FilterFacturas extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT FacturaID, FechaFacturacion, Facturas.TipoFacturaID, Facturas.TirajeFacturaID, CodigoTiraje, Correlativo, ClientesPersonasID, ClientesPersonas.Nombres AS NombreCliente, ClientesPersonas.Apellidos AS ApellidoCliente, EmpleadoID, Empleados.Codigo AS CodigoEmpleado, Empresas.EmpresaID, Empresas.NombreComercial as NombreEmpresa, COALESCE(SUM(PrecioUnitario * Cantidad), 0) AS VentaTotal FROM Facturas INNER JOIN TirajeFacturas USING (TirajeFacturaID) INNER JOIN TiposFactura USING (TipoFacturaID) LEFT JOIN DetalleFactura USING (FacturaID) LEFT JOIN ClientesPersonas USING (ClientesPersonasID) LEFT JOIN Empleados USING (EmpleadoID) LEFT JOIN Empresas USING (EmpresaID) WHERE 1';
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
            'tableName' => 'ClientesPersonas',
            'columnName' => 'Nombres',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'apellidosCliente',
            'tableName' => 'ClientesPersonas',
            'columnName' => 'Apellidos',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nombreEmpresa',
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
        [
            'filterName' => 'tipoFactura',
            'tableName' => 'Facturas',
            'columnName' => 'TipoFacturaID',
            'searchType' => '=',
        ],
    ];
}
