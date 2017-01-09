<?php

namespace Sigmalibre\Empresas\DataSource;

use Sigmalibre\DataSource\MySQL\MySQLReader;

/**
 * Encuentra registros de empresas en la BD, filtradas por cámpos de búsqueda.
 */
class FilterEmpresas extends MySQLReader
{
    protected $baseQuery = 'SELECT EmpresaID, NombreComercial, RazonSocial, Giro, Registro, NIT, DireccionID, Direccion, TelefonoID, Telefono, EmailID, Email FROM Empresas LEFT JOIN Direcciones USING (EmpresaID) LEFT JOIN Telefonos USING (EmpresaID) LEFT JOIN Emails USING (EmpresaID) WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'nombreComercial',
            'tableName' => 'Empresas',
            'columnName' => 'NombreComercial',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'registro',
            'tableName' => 'Empresas',
            'columnName' => 'Registro',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nit',
            'tableName' => 'Empresas',
            'columnName' => 'NIT',
            'searchType' => 'LIKE',
        ],
    ];
}