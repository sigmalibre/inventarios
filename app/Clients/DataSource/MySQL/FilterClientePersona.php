<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

class FilterClientePersona extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT ClientesPersonasID, Nombres, Apellidos, DUI, NIT FROM ClientesPersonas WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
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
            'filterName' => 'duiCliente',
            'tableName' => 'ClientesPersonas',
            'columnName' => 'DUI',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nitCliente',
            'tableName' => 'ClientesPersonas',
            'columnName' => 'NIT',
            'searchType' => 'LIKE',
        ],
    ];
}