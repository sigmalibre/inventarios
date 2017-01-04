<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQL;

/**
 * Guarda almacenes nuevos en la BD.
 */
class SaveNewWarehouse
{
    /** @var  MySQL $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Guarda un almacén nuevo en la BD MySQL.
     *
     * Advertencia: Todos los datos para la creación de la nueva bodega ya deberán llegar validados aquí.
     *
     * @param array $data
     *
     * @return bool|string Retorna la ID de el almacén recién creado; False si no se pudo crear
     */
    public function write(array $data)
    {
        $isSaved = $this->connection->execute('INSERT INTO Almacenes (NombreAlmacen) VALUES (:nombreAlmacen)', $data);

        if ($isSaved === false) {
            return false;
        }

        return $this->connection->lastId();
    }
}