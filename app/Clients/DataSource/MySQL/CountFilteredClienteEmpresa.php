<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

class CountFilteredClienteEmpresa extends FilterClienteEmpresa
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM Empresas WHERE EmpresaID IN (SELECT DISTINCT EmpresaID FROM Facturas)';
    protected $setLimit = false;
}
