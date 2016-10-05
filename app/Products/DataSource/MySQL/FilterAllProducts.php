<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Realiza una búsqueda de los productos en la BD con paginación y filtrado de resultados.
 */
class FilterAllProducts implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($options)
    {
        $statement = 'SELECT codigo_mas, nombre_prov, nombre_cat, nombre_subcat, nombre_mas, foto_mas, marca_mas, excentoiva_mas, saldou_mas, saldov_mas, ingresou_mas, egresou_mas, ingresov_mas, egresou_mas, promedio_mas, fechaingreso_mas, stock_mas, activo, nombre_medida, descripcion_catbiendet, descripcion_reflibrodet FROM tbmaster LEFT JOIN tbproveedor USING (codigo_prov) LEFT JOIN tbcategoriaproductos USING (codigo_cat) LEFT JOIN tbsubcategoria USING (codigo_subcat) LEFT JOIN tbmedida USING (codigo_medida) LEFT JOIN tbcategoriabiendet USING (codigo_catbiendet) LEFT JOIN tbreferencialibrodet USING (codigo_reflibrodet) WHERE 1';

        $filters = [];
        $params = [];

        $input = $options['input'];

        if (empty($input['codigoProducto']) === false) {
            $filters[] = 'tbmaster.codigo_mas LIKE :codigo_mas';
            $params[':codigo_mas'] = $input['codigoProducto'] . '%';
        }

        if (empty($input['categoriaProducto']) === false) {
            $filters[] = 'tbcategoriaproductos.nombre_cat LIKE :nombre_cat';
            $params[':nombre_cat'] = $input['categoriaProducto'] . '%';
        }

        if (empty($input['marcaProducto']) === false) {
            $filters[] = 'tbmaster.marca_mas LIKE :marca_mas';
            $params[':marca_mas'] = $input['marcaProducto'] . '%';
        }

        if (empty($input['nombreProducto']) === false) {
            $filters[] = 'MATCH(tbmaster.nombre_mas) AGAINST(:nombre_mas)';
            $params[':nombre_mas'] = $input['nombreProducto'];
        }

        if (empty($filters) === false) {
            $statement .= ' AND ';
            $statement .= implode(' AND ', $filters);
        }

        $statement .= ' LIMIT '.$options['offset'].', '.$options['items'];

        return $this->connection->query($statement, $params);
    }
}
