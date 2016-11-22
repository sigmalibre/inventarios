<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Realiza una búsqueda de los productos en la BD con paginación y filtrado de resultados.
 */
class FilterAllProducts extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT ProductoID, Productos.Codigo as CodigoProducto, Descripcion, ExcentoIVA, StockMin, PrecioVenta, FechaCreacion, FechaModificacion, UnidadMedida, CategoriaProductoID, CategoriaProductos.Codigo as CodigoCategoria, CategoriaProductos.Nombre as NombreCategoria, MarcaID, Marcas.Nombre as NombreMarca, COALESCE(SUM(DetalleIngresos.Cantidad), 0) - COALESCE(SUM(DetalleFactura.Cantidad), 0) as Cantidad FROM Productos LEFT JOIN CategoriaProductos USING (CategoriaProductoID) LEFT JOIN Marcas USING (MarcaID) LEFT JOIN DetalleIngresos USING (ProductoID) LEFT JOIN DetalleFactura USING (ProductoID) LEFT JOIN Medidas USING (MedidaID) WHERE 1';
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
            'tableName' => 'CategoriaProductos',
            'columnName' => 'CategoriaProductoID',
            'searchType' => '=',
        ],
        [
            'filterName' => 'marcaProducto',
            'tableName' => 'Marcas',
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
