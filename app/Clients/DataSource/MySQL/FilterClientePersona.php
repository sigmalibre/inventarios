<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

/**
 * Obtiene la lista con todos los clientes personas a los que se les haya vendido alguna vez
 * filtrándolos por términos de búsqueda y paginación.
 */
class FilterClientePersona extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT ClientesPersonasID, Nombres, Apellidos, DUI, NIT, DireccionID, Direccion, TelefonoID, Telefono FROM ClientesPersonas LEFT JOIN Direcciones USING (ClientesPersonasID) LEFT JOIN Telefonos USING (ClientesPersonasID) WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'nombresCliente',
            'tableName' => 'ClientesPersonas',
            'columnName' => 'Nombres',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'apellidosCliente',
            'tableName' => 'ClientesPersonas',
            'columnName' => 'Apellidos',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'duiCliente',
            'tableName' => 'ClientesPersonas',
            'columnName' => 'DUI',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nitCliente',
            'tableName' => 'ClientesPersonas',
            'columnName' => 'NIT',
            'searchType' => 'LIKE',
        ],
    ];
}
