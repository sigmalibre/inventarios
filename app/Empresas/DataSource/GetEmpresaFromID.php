<?php

namespace Sigmalibre\Empresas\DataSource;

/**
 * Obtiene la información de una empresa, encontrada por su ID.
 */
class GetEmpresaFromID extends FilterEmpresas
{
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'idEmpresa',
            'tableName' => 'Empresas',
            'columnName' => 'EmpresaID',
            'searchType' => '=',
        ],
    ];
}