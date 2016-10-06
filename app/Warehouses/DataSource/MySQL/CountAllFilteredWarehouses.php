<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

/**
 * Cuenta la cantidad de bodegas que existen en la BD según los términos de búsqueda.
 */
class CountAllFilteredWarehouses implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($options)
    {
        $statement = 'SELECT COUNT(*) as cuenta FROM tbbodegas WHERE 1';

        $filters = [];
        $params = [];

        $input = $options['input'];

        if (empty($input['codigoBodega']) === false) {
            $filters[] = 'codigo_bod LIKE :codigo_bod';
            $params[':codigo_bod'] = $input['codigoBodega'].'%';
        }

        if (empty($input['nombreBodega']) === false) {
            $filters[] = 'nombre_bod LIKE :nombre_bod';
            $params[':nombre_bod'] = $input['nombreBodega'].'%';
        }

        if (empty($filters) === false) {
            $statement .= ' AND ';
            $statement .= implode(' AND ', $filters);
        }

        return $this->connection->query($statement, $params);
    }
}
