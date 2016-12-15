<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

/**
 * Cuenta la cantidad de clientes personas a los que se les haya vendido alguna vez.
 */
class CountFilteredClientePersona extends FilterClientePersona
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM ClientesPersonas WHERE 1';
    protected $setLimit = false;
}
