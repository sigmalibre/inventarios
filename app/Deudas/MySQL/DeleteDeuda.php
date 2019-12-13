<?php

namespace Sigmalibre\Deudas\MySQL;

class DeleteDeuda
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($id)
    {
        return $this->connection->execute('DELETE FROM  Deudas WHERE DeudaID = :id', ['id' => $id]);
    }
}
