<?php

namespace Sigmalibre\DatosGenerales\DataSource\MySQL;

use Sigmalibre\DataSource\WriteInterface;

class UpdateDireccionEmpleado implements WriteInterface
{
	private $connection;

	public function __construct($container)
	{
		$this->connection = $container->mysql;
	}

	public function write($data)
	{
		return $this->connection->execute('UPDATE Direcciones SET Direccion = :direccion WHERE EmpleadoID = :empleadoID', [
			'direccion' => $data['direccion'],
			'empleadoID' => $data['empleadoID'],
		]);
	}
}