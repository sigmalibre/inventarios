<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

class FilterClienteEmpresa extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT EmpresaID, NombreComercial, RazonSocial, Giro, Registro, NIT FROM Empresas WHERE EmpresaID IN (SELECT DISTINCT EmpresaID FROM Facturas)';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'nombreCliente',
            'tableName' => 'Empresas',
            'columnName' => 'NombreComercial',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'registroCliente',
            'tableName' => 'Empresas',
            'columnName' => 'Registro',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nitCliente',
            'tableName' => 'Empresas',
            'columnName' => 'NIT',
            'searchType' => 'LIKE',
        ],
    ];
}
