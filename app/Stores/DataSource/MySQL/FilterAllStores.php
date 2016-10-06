<?php

namespace Sigmalibre\Stores\DataSource\MySQL;

/**
 * Realiza búsquedas filtradas y paginadas de la lista de sucursales.
 */
class FilterAllStores implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($options)
    {
        $statement = 'SELECT codigo_scr, nombre_scr, direccion_scr, telefono_scr FROM tbsucursales WHERE 1';

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

        $statement .= ' LIMIT :offset, :items';

        $params[':offset'] = $options['offset'];
        $params[':items'] = $options['items'];

        return $this->connection->query($statement, $params);
    }
}
