<?php

namespace Sigmalibre\Categories\DataSource\MySQL;

/**
 * Realiza una búsqueda filtrada y paginada de la lista de categorías de producto.
 */
class FilterAllCategories extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT codigo_cat, nombre_cat FROM tbcategoriaproductos WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'codigoCategoria',
            'tableName' => 'tbcategoriaproductos',
            'columnName' => 'codigo_cat',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nombreCategoria',
            'tableName' => 'tbcategoriaproductos',
            'columnName' => 'nombre_cat',
            'searchType' => 'LIKE',
        ],
    ];
}
