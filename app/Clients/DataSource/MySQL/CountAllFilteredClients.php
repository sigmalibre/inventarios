<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

class CountAllFilteredClients extends FilterAllClients
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM tbcliente WHERE 1';
    protected $setLimit = false;
}
