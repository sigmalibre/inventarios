<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Obtiene un solo resultado con la información de un producto según su ID.
 */
class GetProductFromCode extends FilterAllProducts
{
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'codigoProducto',
            'tableName' => 'VistaProductosCompletos',
            'columnName' => 'CodigoProducto',
            'searchType' => '=',
        ],
    ];
}
