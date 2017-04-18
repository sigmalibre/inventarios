<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

class DeleteWarehouse
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($id)
    {
        return $this->connection->execute('DELETE FROM Almacenes WHERE AlmacenID = :id', [
            'id' => $id,
        ]);
    }
}
