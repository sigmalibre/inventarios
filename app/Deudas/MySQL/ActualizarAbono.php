<?php

namespace Sigmalibre\Deudas\MySQL;

class ActualizarAbono
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($id, $cantidad)
    {
        return $this->connection->execute('UPDATE Deudas SET Abonos = :Abono WHERE DeudaID = :id', [
            'id' => $id,
            'Abono' => $cantidad,
        ]);
    }
}
