<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

/**
 * Realiza un conteo de todas las facturas de tipo crédito fiscal en la BD.
 */
class CountFilteredCreditoFiscal extends FilterCreditoFiscal
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM Facturas INNER JOIN TiposFactura USING (TipoFacturaID) INNER JOIN TirajeFacturas USING (TirajeFacturaID) LEFT JOIN Empresas USING (EmpresaID) LEFT JOIN Empleados USING (EmpleadoID) WHERE TipoFacturaID = 2';
    protected $endQuery = '';
    protected $setLimit = false;
}
