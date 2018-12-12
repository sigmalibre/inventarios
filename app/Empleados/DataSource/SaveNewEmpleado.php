<?php

namespace Sigmalibre\Empleados\DataSource;

class SaveNewEmpleado
{
	private $connection;

	public function __construct($container)
	{
		$this->connection = $container->mysql;
	}

	public function write($data)
	{
		$isSaved = $this->connection->execute('INSERT INTO Empleados(Nombres, Apellidos, DUI, NIT, NUP, ISSS, Codigo) VALUES (:nombres, :apellidos, :dui, :nit, :nup, :isss, :codigo)', $data);

		if ($isSaved === false) {
			return false;
		}

		return $this->connection->lastId();
	}
}