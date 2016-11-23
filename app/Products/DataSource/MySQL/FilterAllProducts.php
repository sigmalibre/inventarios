<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Realiza una búsqueda de los productos en la BD con paginación y filtrado de resultados.
 */
class FilterAllProducts extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT ProductoID, Productos.Codigo as CodigoProducto, Descripcion, ExcentoIVA, StockMin, PrecioVenta, FechaCreacion, FechaModificacion, UnidadMedida, CategoriaProductoID, CategoriaProductos.Codigo as CodigoCategoria, CategoriaProductos.Nombre as NombreCategoria, MarcaID, Marcas.Nombre as NombreMarca, COALESCE((SELECT SUM(Cantidad) FROM DetalleIngresos WHERE DetalleIngresos.ProductoID = Productos.ProductoID), 0) - COALESCE((SELECT SUM(Cantidad) FROM DetalleFactura WHERE DetalleFactura.ProductoID = Productos.ProductoID), 0) as Cantidad FROM Productos LEFT JOIN CategoriaProductos USING (CategoriaProductoID) LEFT JOIN Marcas USING (MarcaID) LEFT JOIN Medidas USING (MedidaID) WHERE 1';

    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'codigoProducto',
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
