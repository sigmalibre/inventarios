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
        Productos.Activo as ProductoActivo,
        CodigoLibroDet,
        CodigoBienDet,
        MarcaID,
        Marcas.Nombre AS NombreMarca,
        MedidaID,
        UnidadMedida,
        CategoriaProductoID,
        CategoriaProductos.Nombre AS NombreCategoria,
        COALESCE(SUM(DetalleAlmacenes.Cantidad), 0) AS Cantidad,
        COALESCE((SELECT d.CostoActual FROM DetalleIngresos d WHERE d.ProductoID = Productos.ProductoID ORDER BY d.DetalleIngresosID DESC LIMIT 1), 0) AS CostoActual
    FROM Productos
    LEFT JOIN CategoriaProductos USING (CategoriaProductoID)
    LEFT JOIN Marcas USING (MarcaID)
    LEFT JOIN Medidas USING (MedidaID)
    LEFT JOIN DetalleAlmacenes USING (ProductoID)
    WHERE 1';
    protected $endQuery = "
    GROUP BY ProductoID
    ORDER BY
        case :orderby
        when 'CodigoProducto' then CodigoProducto
        when 'NombreCategoria' then NombreCategoria
        when 'NombreMarca' then NombreMarca
        when 'Descripcion' then Descripcion
        when 'Cantidad' then Cantidad
        when 'CostoActual' then CostoActual
        else CodigoProducto
        end";
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'codigoProducto',
            'tableName' => 'Productos',
            'columnName' => 'Codigo',
            'searchType' => 'SLOWLIKE',
        ],
        [
            'filterName' => 'categoriaProducto',
            'tableName' => 'CategoriaProductos',
            'columnName' => 'Nombre',
            'searchType' => 'SLOWLIKE',
        ],
        [
            'filterName' => 'codigoCategoria',
            'tableName' => 'CategoriaProductos',
            'columnName' => 'CategoriaProductoID',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'marcaProducto',
            'tableName' => 'Marcas',
            'columnName' => 'Nombre',
            'searchType' => 'SLOWLIKE',
        ],
        [
            'filterName' => 'nombreProducto',
            'tableName' => 'Productos',
            'columnName' => 'Descripcion',
            'searchType' => 'SLOWLIKE',
        ],
        [
            'filterName' => 'productoActivo',
            'tableName' => 'Productos',
            'columnName' => 'Activo',
            'searchType' => '=',
        ],
    ];
}
