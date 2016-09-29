<?php

namespace Sigmalibre\Products\DataSource\Mysql;

/**
 * Realiza una búsqueda de los productos en la BD con paginación.
 */
class SearchAllProducts implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($pagination)
    {
        $rowsPerPage = $pagination['perPage'];
        $currentPage = $pagination['currentPage'];

        $totalPages = ceil($pagination['totalCountOfRows'] / $rowsPerPage);

        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        if ($currentPage < 1) {
            $currentPage = 1;
        }

        $offset = ($currentPage - 1) * $rowsPerPage;

        $statement = 'SELECT codigo_mas, nombre_prov, nombre_cat, nombre_subcat, nombre_mas, foto_mas, marca_mas, excentoiva_mas, saldou_mas, saldov_mas, ingresou_mas, egresou_mas, ingresov_mas, egresou_mas, promedio_mas, fechaingreso_mas, stock_mas, activo, nombre_medida, descripcion_catbiendet, descripcion_reflibrodet FROM tbmaster LEFT JOIN tbproveedor USING (codigo_prov) LEFT JOIN tbcategoriaproductos USING (codigo_cat) LEFT JOIN tbsubcategoria USING (codigo_subcat) LEFT JOIN tbmedida USING (codigo_medida) LEFT JOIN tbcategoriabiendet USING (codigo_catbiendet) LEFT JOIN tbreferencialibrodet USING (codigo_reflibrodet) LIMIT '.$offset.', '.$rowsPerPage;

        return $this->connection->query($statement, []);
    }
}
