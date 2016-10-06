<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

/**
 * Realiza búsquedas filtradas y paginadas de la lista de bodegas.
 */
class FilterAllWarehouses implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($options)
    {
        $statement = 'SELECT codigo_bod, nombre_bod, encargado_bod, direccion_bod FROM tbbodegas WHERE 1';

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

        $statement .= ' LIMIT :offset, :items';

        $params[':offset'] = $options['offset'];
        $params[':items'] = $options['items'];

        return $this->connection->query($statement, $params);
    }
}
