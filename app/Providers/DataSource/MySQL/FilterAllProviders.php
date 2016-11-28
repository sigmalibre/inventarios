<?php

namespace Sigmalibre\Providers\DataSource\MySQL;

/**
 * Obtiene una lista de todos los proveedores en la BD que cumplan con los campos de búsqueda del usuario.
 */
class FilterAllProviders extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT EmpresaID, NombreComercial, RazonSocial, Giro, Registro, NIT FROM Empresas WHERE EmpresaID IN (SELECT DISTINCT EmpresaID FROM DetalleIngresos)';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'nombreProveedor',
            'tableName' => 'Empresas',
            'columnName' => 'NombreComercial',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'numregProveedor',
            'tableName' => 'Empresas',
            'columnName' => 'Registro',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nitProveedor',
            'tableName' => 'Empresas',
            'columnName' => 'NIT',
            'searchType' => 'LIKE',
        ],
    ];
}
