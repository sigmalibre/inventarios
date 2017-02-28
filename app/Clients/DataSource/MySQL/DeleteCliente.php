<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

class DeleteCliente
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($id)
    {
        return $this->connection->execute('DELETE FROM ClientesPersonas WHERE ClientesPersonasID = :id', [
            'id' => $id,
        ]);
    }
}
