<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Realiza una búsqueda de los productos en la BD con paginación y filtrado de resultados.
 */
class FilterAllProducts extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT codigo_mas, nombre_prov, nombre_cat, nombre_subcat, nombre_mas, foto_mas, marca_mas, excentoiva_mas, saldou_mas, saldov_mas, ingresou_mas, egresou_mas, ingresov_mas, egresou_mas, promedio_mas, fechaingreso_mas, stock_mas, activo, nombre_medida, descripcion_catbiendet, descripcion_reflibrodet FROM tbmaster LEFT JOIN tbproveedor USING (codigo_prov) LEFT JOIN tbcategoriaproductos USING (codigo_cat) LEFT JOIN tbsubcategoria USING (codigo_subcat) LEFT JOIN tbmedida USING (codigo_medida) LEFT JOIN tbcategoriabiendet USING (codigo_catbiendet) LEFT JOIN tbreferencialibrodet USING (codigo_reflibrodet) WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'codigoProducto',
            'tableName' => 'tbmaster',
            'columnName' => 'codigo_mas',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'categoriaProducto',
            'tableName' => 'tbcategoriaproductos',
            'columnName' => 'nombre_cat',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'marcaProducto',
            'tableName' => 'tbmaster',
            'columnName' => 'marca_mas',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nombreProducto',
            'tableName' => 'tbmaster',
            'columnName' => 'nombre_mas',
            'searchType' => 'MATCH',
        ],
    ];
}
