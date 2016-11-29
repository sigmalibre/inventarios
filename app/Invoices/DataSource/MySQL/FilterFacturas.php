<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

class FilterFacturas extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT FacturaID, FechaFacturacion, CodigoTiraje, Correlativo, ClientesPersonas.Nombres AS NombreCliente, ClientesPersonas.Apellidos AS ApellidoCliente, Empleados.Codigo AS CodigoEmpleado, COALESCE(SUM(PrecioUnitario * Cantidad), 0) AS VentaTotal FROM Facturas INNER JOIN TiposFactura USING (TipoFacturaID) INNER JOIN TirajeFacturas USING (TirajeFacturaID) LEFT JOIN DetalleFactura USING (FacturaID) LEFT JOIN ClientesPersonas USING (ClientesPersonasID) LEFT JOIN Empleados USING (EmpleadoID) WHERE TipoFacturaID = 1';
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
            'filterName' => 'codigoEmpleado',
            'tableName' => 'Empleados',
            'columnName' => 'Codigo',
            'searchType' => 'LIKE',
        ],
    ];
}
