<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

/**
 * Realiza una búsqueda filtrada y paginada de la lista de clientes.
 */
class FilterAllClients extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT codigo_cln, nombre_cln, apellido_cln, NIT_cln, DUI_cln, direccion_cln, municipio_cln, departamento_cln, telefono_cln FROM tbcliente WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'codigoCliente',
            'tableName' => 'tbcliente',
            'columnName' => 'codigo_cln',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nombreCliente',
            'tableName' => 'tbcliente',
            'columnName' => 'nombre_cln',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nitCliente',
            'tableName' => 'tbcliente',
            'columnName' => 'NIT_cln',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'duiCliente',
            'tableName' => 'tbcliente',
            'columnName' => 'DUI_cln',
            'searchType' => 'LIKE',
        ],
    ];
}
