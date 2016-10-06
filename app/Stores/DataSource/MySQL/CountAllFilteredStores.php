<?php

namespace Sigmalibre\Stores\DataSource\MySQL;

/**
 * Cuenta la cantidad de sucursales que existen en la BD según los términos de búsqueda.
 */
class CountAllFilteredStores implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($options)
    {
        $statement = 'SELECT COUNT(*) as cuenta FROM tbsucursales WHERE 1';

        $filters = [];
        $params = [];

        $input = $options['input'];

        if (empty($input['codigoSucursal']) === false) {
            $filters[] = 'codigo_scr LIKE :codigo_scr';
            $params[':codigo_scr'] = $input['codigoSucursal'].'%';
        }

        if (empty($input['nombreSucursal']) === false) {
            $filters[] = 'nombre_scr LIKE :nombre_scr';
            $params[':nombre_scr'] = $input['nombreSucursal'].'%';
        }

        if (empty($filters) === false) {
            $statement .= ' AND ';
            $statement .= implode(' AND ', $filters);
        }

        return $this->connection->query($statement, $params);
    }
}
