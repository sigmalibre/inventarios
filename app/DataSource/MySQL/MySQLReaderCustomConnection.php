<?php

namespace Sigmalibre\DataSource\MySQL;

/**
 * Lector de listas MySQL, que acepta conexiones personalizadas.
 */
class MySQLReaderCustomConnection extends MySQLReader
{
    public function __construct($connection)
    {
        $this->connection = $connection;
    }
}
