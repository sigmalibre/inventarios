<?php

namespace Sigmalibre\Products\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

class DeleteFromCategory
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($categoryID)
    {
        return $this->connection->execute('DELETE FROM Productos WHERE CategoriaProductoID = :categoryID', [
            'categoryID' => $categoryID,
        ]);
    }
}
