<?php

namespace Sigmalibre\Providers\DataSource\MySQL;

/**
 * Realiza un conteo en la BD de todos los proveedores que cumplan con los terminos de búsqueda del usuario.
 */
class CountAllFilteredProviders implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($options)
    {
        $statement = 'SELECT COUNT(*) as cuenta FROM tbproveedor WHERE 1';

        $filters = [];
        $params = [];

        $input = $options['input'];

        if (empty($input['codigoProveedor']) === false) {
            $filters[] = 'codigo_prov LIKE :codigo_prov';
            $params[':codigo_prov'] = $input['codigoProveedor'].'%';
        }

        if (empty($input['nombreProveedor']) === false) {
            $filters[] = 'nombre_prov LIKE :nombre_prov';
            $params[':nombre_prov'] = $input['nombreProveedor'].'%';
        }

        if (empty($input['numregProveedor']) === false) {
            $filters[] = 'numreg_prov LIKE :numreg_prov';
            $params[':numreg_prov'] = $input['numregProveedor'].'%';
        }

        if (empty($input['nitProveedor']) === false) {
            $filters[] = 'numnit_prov LIKE :numnit_prov';
            $params[':numnit_prov'] = $input['nitProveedor'].'%';
        }

        if (empty($filters) === false) {
            $statement .= ' AND ';
            $statement .= implode(' AND ', $filters);
        }

        return $this->connection->query($statement, $params);
    }
}
