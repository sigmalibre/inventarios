<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

/**
 * Obtener un cliente a partir de su ID.
 */
class GetClienteFromID extends FilterClientePersona
{
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'idClientePersona',
            'tableName' => 'ClientesPersonas',
            'columnName' => 'ClientesPersonasID',
            'searchType' => '=',
        ],
    ];
}