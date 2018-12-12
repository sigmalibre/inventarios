<?php

namespace Sigmalibre\DatosGenerales\DataSource\MySQL;

use Sigmalibre\DataSource\WriteInterface;

class UpdateTelefonoEmpleado implements WriteInterface
{
    private $connection;

    function __construct($container)
    {
        $this->connection = $container->mysql;
	}

    public function write($data)
    {
        return $this->connection->execute('UPDATE Telefonos SET Telefono = :telefono WHERE EmpleadoID = :empleadoID', [
            'telefono' => $data['telefono'],
            'empleadoID' => $data['empleadoID'],
        ]);
    }
}