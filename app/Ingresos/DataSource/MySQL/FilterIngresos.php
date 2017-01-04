<?php

namespace Sigmalibre\Ingresos\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReader;

/**
 * Obtiene datos de los ingresos de productos filtrados por términos de búsqueda.
 */
class FilterIngresos extends MySQLReader
{
    protected $baseQuery = 'SELECT DetalleIngresosID, Cantidad, PrecioUnitario, CostoActual, FechaIngreso, ProductoID, Productos.Codigo AS CodigoProducto, CategoriaProductoID, EmpresaID, Registro AS RegistroProveedor FROM DetalleIngresos LEFT JOIN Productos USING (ProductoID) LEFT JOIN Empresas USING (EmpresaID) WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'claveProducto',
            'tableName' => 'Productos',
            'columnName' => 'Codigo',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'codigoCategoria',
            'tableName' => 'Productos',
            'columnName' => 'CategoriaProductoID',
            'searchType' => '=',
        ],
        [
            'filterName' => 'numregProveedor',
            'tableName' => 'Empresas',
            'columnName' => 'Registro',
            'searchType' => 'LIKE',
        ],
    ];
}