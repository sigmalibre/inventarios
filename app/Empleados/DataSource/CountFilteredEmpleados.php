<?php

namespace Sigmalibre\Empleados\DataSource;

class CountFilteredEmpleados extends FilterEmpleados
{
	protected $baseQuery = 'SELECT COUNT(*) AS cuenta FROM Empleados WHERE 1';
	protected $setLimit = false;
}