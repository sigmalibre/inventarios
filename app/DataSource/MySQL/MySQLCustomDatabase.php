<?php

namespace Sigmalibre\DataSource\MySQL;

/**
 * Crea conexiones a una BD especificada.
 */
class MySQLCustomDatabase extends MySQLTransactions
{
    /**
     * MySQLCustomDatabase constructor.
     *
     * @param string $database
     */
    public function __construct($database)
    {
        $dsn = 'mysql:dbname='.$database.';host=localhost;charset=utf8mb4';

        $this->connection = new \PDO($dsn, 'invuser', 'invpass');
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        $this->connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }
}
