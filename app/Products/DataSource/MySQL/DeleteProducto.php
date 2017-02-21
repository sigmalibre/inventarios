<?php

namespace Sigmalibre\Products\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

class DeleteProducto
{
    /** @var MySQLTransactions */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($id)
    {
        return $this->connection->execute('DELETE FROM Productos WHERE ProductoID = :id', [
            'id' => $id,
        ]);
    }
}
