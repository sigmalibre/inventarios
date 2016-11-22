<?php

namespace Sigmalibre\Brands\DataSource\MySQL;

class FilterAllBrands extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT MarcaID, Nombre FROM Marcas WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'nombreMarca',
            'tableName' => 'Marcas',
            'columnName' => 'Nombre',
            'searchType' => 'LIKE',
        ],
    ];
}
