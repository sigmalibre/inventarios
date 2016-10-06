<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

class FilterAllClients implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($options)
    {
        $statement = 'SELECT codigo_cln, nombre_cln, apellido_cln, NIT_cln, DUI_cln, direccion_cln, municipio_cln, departamento_cln, telefono_cln FROM tbcliente WHERE 1';

        $filters = [];
        $params = [];

        $input = $options['input'];

        if (empty($input['codigoCliente']) === false) {
            $filters[] = 'nombre_cln LIKE :codigo_cln';
            $params[':codigo_cln'] = $input['codigoCliente'].'%';
        }

        if (empty($input['nombreCliente']) === false) {
            $filters[] = 'nombre_cln LIKE :nombre_cln';
            $params[':nombre_cln'] = $input['nombreCliente'].'%';
        }

        if (empty($input['nitCliente']) === false) {
            $filters[] = 'NIT_cln LIKE :NIT_cln';
            $params[':NIT_cln'] = $input['nitCliente'].'%';
        }

        if (empty($input['duiCliente']) === false) {
            $filters[] = 'DUI_cln LIKE :DUI_cln';
            $params[':DUI_cln'] = $input['duiCliente'].'%';
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
