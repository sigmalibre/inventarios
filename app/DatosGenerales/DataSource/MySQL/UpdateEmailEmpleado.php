<?php

namespace Sigmalibre\DatosGenerales\DataSource\MySQL;

use Sigmalibre\DataSource\WriteInterface;

class UpdateEmailEmpleado implements WriteInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($data)
    {
        return $this->connection->execute('UPDATE Emails SET Email = :email WHERE EmpleadoID = :empleadoID', [
            'email' => $data['email'],
            'empleadoID' => $data['empleadoID'],
        ]);
    }
}