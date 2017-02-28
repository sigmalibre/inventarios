<?php

namespace Sigmalibre\UnitsOfMeasurement\DataSource\MySQL;


class DeleteUnit
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($id)
    {
        return $this->connection->execute('DELETE FROM Medidas WHERE MedidaID = :id', [
            'id' => $id,
        ]);
    }
}
