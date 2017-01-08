<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQL;

/**
 * Realiza operaciones UPDATE sobre los datos de un almacén.
 */
class UpdateWarehouse
{
    /** @var  MySQL $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Ejecuta una actualización de los datos de un almacen en la BD.
     *
     * Advertencia: el input del usuario ya deberá estar validado aquí.
     *
     * @param array $data
     *
     * @return bool
     */
    public function write(array $data)
    {
        return $this->connection->execute('UPDATE Almacenes SET NombreAlmacen = :nombreAlmacen WHERE AlmacenID = :id', $data);
    }
}