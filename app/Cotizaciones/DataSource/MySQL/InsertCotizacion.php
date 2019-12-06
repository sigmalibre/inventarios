<?php

namespace Sigmalibre\Cotizaciones\DataSource\MySQL;

/**
 * Inserción de Cotizaciones nuevas a la BD.
 */
class InsertCotizacion
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($newDataList)
    {
        return $this->connection->execute('INSERT INTO Cotizaciones (Datos, ClientesPersonasID, EmpleadoID) VALUES (:datos, :cliente, :empleado)', $newDataList);
    }
}
