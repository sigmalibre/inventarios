<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Realiza una búsqueda de los productos en la BD con paginación y filtrado de resultados.
 */
class FilterAllProducts extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT ProductoID, Productos.Codigo as CodigoProducto, Descripcion, ExcentoIVA, StockMin, Utilidad, FechaCreacion, FechaModificacion, UnidadMedida, CategoriaProductoID, CategoriaProductos.Nombre as NombreCategoria, MarcaID, Marcas.Nombre as NombreMarca, COALESCE((SELECT SUM(Cantidad) FROM DetalleIngresos WHERE DetalleIngresos.ProductoID = Productos.ProductoID), 0) - COALESCE((SELECT SUM(Cantidad) FROM DetalleFactura WHERE DetalleFactura.ProductoID = Productos.ProductoID), 0) as Cantidad FROM Productos LEFT JOIN CategoriaProductos USING (CategoriaProductoID) LEFT JOIN Marcas USING (MarcaID) LEFT JOIN Medidas USING (MedidaID) WHERE 1';

    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'claveProducto',
            'tableName' => 'Productos',
            'columnName' => 'Codigo',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'categoriaProducto',
            'tableName' => 'Productos',
            'columnName' => 'CategoriaProductoID',
            'searchType' => '=',
        ],
        [
            'filterName' => 'codigoCategoria',
            'tableName' => 'CategoriaProductos',
            'columnName' => 'CategoriaProductoID',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'marcaProducto',
            'tableName' => 'Productos',
            'columnName' => 'MarcaID',
            'searchType' => '=',
        ],
        [
            'filterName' => 'nombreProducto',
            'tableName' => 'Productos',
            'columnName' => 'Descripcion',
            'searchType' => 'MATCH',
        ],
    ];
}
