<?php

namespace Sigmalibre\Categories\DataSource\MySQL;

/**
 * Consulta la BD para saber la cantidad de categorías de producto según los términos de búsqueda.
 */
class CountAllFilteredCategories implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($options)
    {
        $statement = 'SELECT COUNT(*) as cuenta FROM tbcategoriaproductos WHERE 1';

        $filters = [];
        $params = [];

        $input = $options['input'];

        if (empty($input['codigoCategoria']) === false) {
            $filters[] = 'codigo_cat LIKE :codigo_cat';
            $params[':codigo_cat'] = $input['codigoCategoria'].'%';
        }

        if (empty($input['nombreCategoria']) === false) {
            $filters[] = 'nombre_cat LIKE :nombre_cat';
            $params[':nombre_cat'] = $input['nombreCategoria'].'%';
        }

        if (empty($filters) === false) {
            $statement .= ' AND ';
            $statement .= implode(' AND ', $filters);
        }

        return $this->connection->query($statement, $params);
    }
}
