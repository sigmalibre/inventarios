<?php

namespace Sigmalibre\Providers\DataSource\MySQL;

/**
 * Obtiene una lista de todos los proveedores en la BD que cumplan con los campos de búsqueda del usuario.
 */
class FilterAllProviders extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT codigo_prov, nombre_prov, numreg_prov, numnit_prov, direccion_prov, contacto_prov, telefono_prov, cel_prov, email_prov FROM tbproveedor WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'codigoProveedor',
            'tableName' => 'tbproveedor',
            'columnName' => 'codigo_prov',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nombreProveedor',
            'tableName' => 'tbproveedor',
            'columnName' => 'nombre_prov',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'numregProveedor',
            'tableName' => 'tbproveedor',
            'columnName' => 'numreg_prov',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nitProveedor',
            'tableName' => 'tbproveedor',
            'columnName' => 'numnit_prov',
            'searchType' => 'LIKE',
        ],
    ];
}
