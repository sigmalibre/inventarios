<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

class CountFilteredClientePersona extends FilterClientePersona
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM ClientesPersonas WHERE 1';
    protected $setLimit = false;
}
