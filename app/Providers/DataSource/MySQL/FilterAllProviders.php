<?php

namespace Sigmalibre\Providers\DataSource\MySQL;

/**
 * Obtiene una lista de todos los proveedores en la BD que cumplan con los campos de búsqueda del usuario.
 */
class FilterAllProviders implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($options)
    {
        $statement = 'SELECT codigo_prov, nombre_prov, numreg_prov, numnit_prov, direccion_prov, contacto_prov, telefono_prov, cel_prov, email_prov FROM tbproveedor WHERE 1';

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

        $statement .= ' LIMIT '.$options['offset'].', '.$options['items'];

        return $this->connection->query($statement, $params);
    }
}
