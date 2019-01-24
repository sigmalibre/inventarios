<?php

namespace Sigmalibre\Empleados\DataSource;

use Sigmalibre\DataSource\MySQL\MySQLReader;
//SELECT EmpleadoID, CONCAT(Nombres, ' ', Apellidos) as Empleado, FacturaID, Cantidad * PrecioUnitario as Total, FechaFacturacion FROM `detallefactura` INNER JOIN facturas USING(FacturaID) LEFT JOIN empleados USING (EmpleadoID)
class GetFacturas extends MySQLReader
{
	protected $baseQuery = 'SELECT EmpleadoID, Nombres, Apellidos, DUI, NIT, NUP, ISSS, Codigo, DireccionID, Direccion, TelefonoID, Telefono, EmailID, Email FROM Empleados LEFT JOIN Direcciones USING (EmpleadoID) LEFT JOIN Telefonos USING (EmpleadoID) LEFT JOIN Emails USING (EmpleadoID) WHERE 1';
	protected $setLimit = false;
}