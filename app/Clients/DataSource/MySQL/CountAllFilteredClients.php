<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

class CountAllFilteredClients implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($options)
    {
        $statement = 'SELECT COUNT(*) as cuenta FROM tbcliente WHERE 1';

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

        return $this->connection->query($statement, $params);
    }
}
