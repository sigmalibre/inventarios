<?php

namespace Sigmalibre\Empleados\DataSource;


class DeleteEmpleado
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($id)
    {
        return $this->connection->execute('DELETE FROM Empleados WHERE EmpleadoID = :id', [
            'id' => $id,
        ]);
    }
}
