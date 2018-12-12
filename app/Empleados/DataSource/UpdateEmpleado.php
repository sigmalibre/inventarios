<?php

namespace Sigmalibre\Empleados\DataSource;

class UpdateEmpleado
{
	private $connection;

	public function __construct($container)
	{
		$this->connection = $container->mysql;
	}

	public function write($data)
	{
		return $this->connection->execute('UPDATE Empleados SET Nombres = :nombres, Apellidos = :apellidos, DUI = :dui, NIT = :nit, NUP = :nup, ISSS = :isss, Codigo = :codigo WHERE EmpleadoID = :id', $data);
	}
}