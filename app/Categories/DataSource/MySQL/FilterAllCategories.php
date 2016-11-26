<?php

namespace Sigmalibre\Categories\DataSource\MySQL;

/**
 * Realiza una búsqueda filtrada y paginada de la lista de categorías de producto.
 */
class FilterAllCategories extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT CategoriaProductoID, Nombre FROM CategoriaProductos WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'codigoCategoria',
            'tableName' => 'CategoriaProductos',
            'columnName' => 'CategoriaProductoID',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nombreCategoria',
            'tableName' => 'CategoriaProductos',
            'columnName' => 'Nombre',
            'searchType' => 'LIKE',
        ],
    ];
}
