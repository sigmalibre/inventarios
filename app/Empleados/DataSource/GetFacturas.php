<?php

namespace Sigmalibre\Empleados\DataSource;

class GetFacturas
{
	private $connection;

	public function __construct($container)
	{
		$this->connection = $container->mysql;
	}

	public function read($year)
	{
		return $this->connection->query('SELECT EmpleadoID, Codigo, CONCAT(Nombres, \' \', Apellidos) as Empleado, FacturaID, SUM(Cantidad * PrecioUnitario) as Total, FechaFacturacion FROM DetalleFactura INNER JOIN Facturas USING(FacturaID) LEFT JOIN Empleados USING (EmpleadoID) WHERE FechaFacturacion BETWEEN :start AND :end GROUP BY FacturaID', [
			'start' => $year . '-01-01',
			'end' => $year . '-12-31',
		]);
	}
}