<?php

namespace Sigmalibre\Brands\DataSource\MySQL;

/**
 * Obtiene un solo resultado con la información de una marca de producto.
 */
class GetBrandFromID extends FilterAllBrands
{
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'idMarca',
            'tableName' => 'Marcas',
            'columnName' => 'MarcaID',
            'searchType' => '=',
        ],
    ];
}
