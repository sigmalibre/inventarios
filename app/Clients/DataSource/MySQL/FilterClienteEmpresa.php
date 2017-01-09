<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

/**
 * Obtiene la lista con todos los clientes contribuyentes a los que se les haya vendido alguna vez
 * filtrándolos por términos de búsqueda y paginación.
 */
class FilterClienteEmpresa extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT EmpresaID, NombreComercial, RazonSocial, Giro, Registro, NIT, DireccionID, Direccion, TelefonoID, Telefono, EmailID, Email FROM Empresas LEFT JOIN Direcciones USING (EmpresaID) LEFT JOIN Telefonos USING (EmpresaID) LEFT JOIN Emails USING (EmpresaID) WHERE EmpresaID IN (SELECT DISTINCT EmpresaID FROM Facturas)';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'nombreCliente',
            'tableName' => 'Empresas',
            'columnName' => 'NombreComercial',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'registroCliente',
            'tableName' => 'Empresas',
            'columnName' => 'Registro',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nitCliente',
            'tableName' => 'Empresas',
            'columnName' => 'NIT',
            'searchType' => 'LIKE',
        ],
    ];
}
