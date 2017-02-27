<?php

namespace Sigmalibre\Products\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

class UpdateCategory
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($toReplaceID, $replacementID)
    {
        return $this->connection->execute('UPDATE Productos SET CategoriaProductoID = :replacementID WHERE CategoriaProductoID = :toReplaceID', [
            'replacementID' => $replacementID,
            'toReplaceID' => $toReplaceID,
        ]);
    }
}
