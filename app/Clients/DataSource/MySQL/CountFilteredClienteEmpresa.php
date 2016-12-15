<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

/**
 * Cuenta la cantidad de clientes contribuyentes a los que se les haya vendido alguna vez.
 */
class CountFilteredClienteEmpresa extends FilterClienteEmpresa
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM Empresas WHERE EmpresaID IN (SELECT DISTINCT EmpresaID FROM Facturas)';
    protected $setLimit = false;
}
