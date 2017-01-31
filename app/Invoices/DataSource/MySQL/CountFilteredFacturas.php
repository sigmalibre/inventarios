<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

/**
 * Realiza un conteo de todas las facturas de tipo consumidor final en la BD.
 */
class CountFilteredFacturas extends FilterFacturas
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM Facturas INNER JOIN TirajeFacturas USING (TirajeFacturaID) INNER JOIN TiposFactura USING (TipoFacturaID) LEFT JOIN ClientesPersonas USING (ClientesPersonasID) LEFT JOIN Empleados USING (EmpleadoID) LEFT JOIN Empresas USING (EmpresaID) WHERE 1';
    protected $endQuery = '';
    protected $setLimit = false;
}
