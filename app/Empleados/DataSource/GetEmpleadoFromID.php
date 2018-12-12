<?php

namespace Sigmalibre\Empleados\DataSource;

class GetEmpleadoFromID extends FilterEmpleados
{
	protected $setLimit = false;
	protected $filterFields = [
		[
			'filterName' => 'idEmpleado',
			'tableName' => 'Empleados',
			'columnName' => 'EmpleadoID',
			'searchType' => '=',
		],
	];
}