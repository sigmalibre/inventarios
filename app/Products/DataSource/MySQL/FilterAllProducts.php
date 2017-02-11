<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Realiza una búsqueda de los productos en la BD con paginación y filtrado de resultados.
 */
class FilterAllProducts extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT ProductoID, CodigoProducto, Descripcion, ExcentoIVA, StockMin, Utilidad, FechaCreacion, FechaModificacion, CodigoLibroDet, CodigoBienDet, MarcaID, NombreMarca, MedidaID, UnidadMedida, CategoriaProductoID, NombreCategoria, Cantidad, CostoActual FROM VistaProductosCompletos WHERE 1';

    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'claveProducto',
            'tableName' => 'VistaProductosCompletos',
            'columnName' => 'CodigoProducto',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'categoriaProducto',
            'tableName' => 'VistaProductosCompletos',
            'columnName' => 'CategoriaProductoID',
            'searchType' => '=',
        ],
        [
            'filterName' => 'codigoCategoria',
            'tableName' => 'VistaProductosCompletos',
            'columnName' => 'CategoriaProductoID',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'marcaProducto',
            'tableName' => 'VistaProductosCompletos',
            'columnName' => 'MarcaID',
            'searchType' => '=',
        ],
        [
            'filterName' => 'nombreProducto',
            'tableName' => 'VistaProductosCompletos',
            'columnName' => 'Descripcion',
            'searchType' => 'LIKE',
        ],
    ];
}
