<?php

namespace Sigmalibre\Accounts\DataSource;

use Sigmalibre\DataSource\MySQL\MySQLReader;

class GetUsers extends MySQLReader
{
    protected $baseQuery = 'SELECT UsuarioID, Username, Password FROM Usuarios WHERE 1';
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'user',
            'tableName'  => 'Usuarios',
            'columnName' => 'Username',
            'searchType' => '=',
        ],
    ];
}
