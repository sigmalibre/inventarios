<?php

namespace Sigmalibre\Empleados\DataSource;

use Sigmalibre\DataSource\MySQL\MySQLReader;

class FilterEmpleados extends MySQLReader
{
	protected $baseQuery = 'SELECT EmpleadoID, Nombres, Apellidos, DUI, NIT, NUP, ISSS, Codigo, DireccionID, Direccion, TelefonoID, Telefono, EmailID, Email FROM Empleados LEFT JOIN Direcciones USING (EmpleadoID) LEFT JOIN Telefonos USING (EmpleadoID) LEFT JOIN Emails USING (EmpleadoID) WHERE 1';
	protected $setLimit = true;
	protected $filterFields = [
		[
			'filterName' => 'nombres',
			'tableName' => 'Empleados',
			'columnName' => 'Nombres',
			'searchType' => 'LIKE',
		],
		[
			'filterName' => 'apellidos',
			'tableName' => 'Empleados',
			'columnName' => 'Apellidos',
			'searchType' => 'LIKE',
		],
		[
			'filterName' => 'dui',
			'tableName' => 'Empleados',
			'columnName' => 'DUI',
			'searchType' => 'LIKE',
		],
		[
			'filterName' => 'codigo',
			'tableName' => 'Empleados',
			'columnName' => 'Codigo',
			'searchType' => 'LIKE',
		],
	];
}