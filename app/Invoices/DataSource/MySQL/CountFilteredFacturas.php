<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

class CountFilteredFacturas extends FilterFacturas
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM Facturas INNER JOIN TiposFactura USING (TipoFacturaID) INNER JOIN TirajeFacturas USING (TirajeFacturaID) LEFT JOIN ClientesPersonas USING (ClientesPersonasID) LEFT JOIN Empleados USING (EmpleadoID) WHERE TipoFacturaID = 1';
    protected $endQuery = '';
    protected $setLimit = false;
}
