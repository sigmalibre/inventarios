<?php

namespace Sigmalibre\Ingresos\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReader;

/**
 * Obtiene datos de los ingresos de productos filtrados por términos de búsqueda.
 */
class FilterIngresos extends MySQLReader
{
    protected $baseQuery = '
      SELECT
        DetalleIngresosID,
        Cantidad,
        PrecioUnitario,
        CostoActual,
        FechaIngreso,
        ProductoID,
        Productos.Codigo AS CodigoProducto,
        Descripcion,
        Marcas.Nombre AS NombreMarca,
        UnidadMedida,
        CategoriaProductoID,
        CategoriaProductos.Nombre AS NombreCategoria,
        EmpresaID,
        NombreComercial AS Proveedor,
        Registro AS RegistroProveedor,
        AlmacenID,
        NombreAlmacen,
        DeAjuste,
        esDevolucion
      FROM DetalleIngresos
      LEFT JOIN Productos USING (ProductoID)
      LEFT JOIN CategoriaProductos USING (CategoriaProductoID)
      LEFT JOIN Marcas USING (MarcaID)
      LEFT JOIN Medidas USING (MedidaID)
      LEFT JOIN Empresas USING (EmpresaID)
      LEFT JOIN Almacenes USING (AlmacenID)
      WHERE 1';
    protected $endQuery = 'ORDER BY DetalleIngresosID DESC';
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
            'tableName' => 'Productos',
            'columnName' => 'CategoriaProductoID',
            'searchType' => '=',
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
            'filterName' => 'nombreProveedor',
            'tableName' => 'Empresas',
            'columnName' => 'NombreComercial',
            'searchType' => 'SLOWLIKE',
        ],
        [
            'filterName' => 'almacenID',
            'tableName' => 'DetalleIngresos',
            'columnName' => 'AlmacenID',
            'searchType' => '=',
        ],
        [
            'filterName' => 'fechaDesde',
            'tableName' => 'DetalleIngresos',
            'columnName' => 'FechaIngreso',
            'searchType' => '>=',
        ],
        [
            'filterName' => 'fechaHasta',
            'tableName' => 'DetalleIngresos',
            'columnName' => 'FechaIngreso',
            'searchType' => '<=',
        ],
    ];
}