<?php

namespace Sigmalibre\Categories\DataSource\MySQL;

/**
 * Obtiene un solo resultado con la información de una categoría de producto según su ID.
 */
class GetCategoryFromID extends FilterAllCategories
{
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'codigoCategoria',
            'tableName' => 'CategoriaProductos',
            'columnName' => 'CategoriaProductoID',
            'searchType' => '=',
        ],
    ];
}
