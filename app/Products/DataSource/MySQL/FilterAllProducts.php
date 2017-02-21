<?php

namespace Sigmalibre\Products\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReader;

/**
 * Realiza una búsqueda de los productos en la BD con paginación y filtrado de resultados.
 */
class FilterAllProducts extends MySQLReader
{
    protected $baseQuery = '
    SELECT
        ProductoID,
        Productos.Codigo AS CodigoProducto,
        Descripcion,
        ExcentoIVA,
        StockMin,
        Utilidad,
        FechaCreacion,
        FechaModificacion,
        CodigoLibroDet,
        CodigoBienDet,
        MarcaID,
        Marcas.Nombre AS NombreMarca,
        MedidaID,
        UnidadMedida,
        CategoriaProductoID,
        CategoriaProductos.Nombre AS NombreCategoria,
        COALESCE(SUM(DetalleAlmacenes.Cantidad), 0) AS Cantidad,
        COALESCE((SELECT CostoActual FROM DetalleIngresos GROUP BY ProductoID DESC HAVING DetalleIngresos.ProductoID = Productos.ProductoID), 0) AS CostoActual
    FROM Productos
    LEFT JOIN CategoriaProductos USING (CategoriaProductoID)
    LEFT JOIN Marcas USING (MarcaID)
    LEFT JOIN Medidas USING (MedidaID)
    LEFT JOIN DetalleAlmacenes USING (ProductoID)
    WHERE 1';
    protected $endQuery = 'GROUP BY ProductoID';
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
            'searchType' => 'LIKE',
        ],
    ];
}
