<?php

namespace Sigmalibre\Ingresos\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReader;

/**
 * Obtiene datos de los ingresos de productos filtrados por términos de búsqueda.
 */
class FilterIngresos extends MySQLReader
{
    protected $baseQuery = 'SELECT DetalleIngresosID, Cantidad, PrecioUnitario, CostoActual, FechaIngreso, ProductoID, Productos.Codigo AS CodigoProducto, CategoriaProductoID, EmpresaID, NombreComercial AS Proveedor, Registro AS RegistroProveedor, AlmacenID, NombreAlmacen FROM DetalleIngresos LEFT JOIN Productos USING (ProductoID) LEFT JOIN Empresas USING (EmpresaID) LEFT JOIN Almacenes USING (AlmacenID) WHERE 1';
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
            'filterName' => 'codigoCategoria',
            'tableName' => 'Productos',
            'columnName' => 'CategoriaProductoID',
            'searchType' => '=',
        ],
        [
            'filterName' => 'nombreProveedor',
            'tableName' => 'Empresas',
            'columnName' => 'NombreComercial',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'almacenID',
            'tableName' => 'DetalleIngresos',
            'columnName' => 'AlmacenID',
            'searchType' => '=',
        ],
    ];
}