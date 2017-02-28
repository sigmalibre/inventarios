<?php

namespace Sigmalibre\Products\DataSource\MySQL;


class DeleteFromMedida
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($id)
    {
        return $this->connection->execute('DELETE FROM Productos WHERE MedidaID = :id', [
            'id' => $id,
        ]);
    }
}
