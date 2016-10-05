<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

class CountAllFilteredInvoices implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($options)
    {
        $statement = 'SELECT COUNT(*) as cuenta FROM tbfactura LEFT JOIN tbempresa ON tbfactura.codigo_emp = tbempresa.codigo_cmp LEFT JOIN tbcliente USING (codigo_cln) LEFT JOIN tbsucursales USING (codigo_scr) LEFT JOIN tbuser ON tbfactura.facturadopor_fct = tbuser.codigo_user WHERE 1';

        $filters = [];
        $params = [];

        $input = $options['input'];

        if (empty($input['codigoFactura']) === false) {
            $filters[] = 'tbfactura.codigo_fct LIKE :codigo_fct';
            $params[':codigo_fct'] = $input['codigoFactura'].'%';
        }

        if (empty($input['nombreSucursal']) === false) {
            $filters[] = 'tbsucursales.nombre_scr LIKE :nombre_scr';
            $params[':nombre_scr'] = $input['nombreSucursal'].'%';
        }

        if (empty($input['facturadoPor']) === false) {
            $filters[] = 'tbuser.usuario_user LIKE :usuario_user';
            $params[':usuario_user'] = $input['facturadoPor'].'%';
        }

        if (empty($filters) === false) {
            $statement .= ' AND ';
            $statement .= implode(' AND ', $filters);
        }

        return $this->connection->query($statement, $params);
    }
}
