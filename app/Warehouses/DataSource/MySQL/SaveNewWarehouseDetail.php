<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

/**
 * Inserta detalles de cantidad de producto en almacenes.
 */
class SaveNewWarehouseDetail
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container;
    }

    /**
     * Guarda un nuevo detalle de la cantidad de producto en un almacén.
     *
     * Advertencia: los datos deberán llegar ya validados en este punto.
     *
     * @param $data
     *
     * @return bool|string
     */
    public function write($data)
    {
        $isSaved = $this->connection->execute('INSERT INTO DetalleAlmacenes (Cantidad, AlmacenID, ProductoID) VALUES (:cantidadIngreso, :almacenID, :productoID)', $data);

        if ($isSaved === false) {
            return false;
        }

        return $this->connection->lastId();
    }
}