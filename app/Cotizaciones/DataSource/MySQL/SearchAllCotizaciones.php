<?php

namespace Sigmalibre\Cotizaciones\DataSource\MySQL;

/**
 * Obtiene la lista de todas las cotizaciones desde la BD.
 */
class SearchAllCotizaciones extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT CotizacionID, cot.FechaCreacion, Datos, CONCAT(c.Nombres, \' \', c.Apellidos) as Cliente, Codigo, CONCAT(e.Nombres, \' \', e.Apellidos) as Empleado FROM Cotizaciones cot LEFT JOIN ClientesPersonas c USING(ClientesPersonasID) LEFT JOIN Empleados e USING(EmpleadoID)';
    protected $setLimit = false;
}
