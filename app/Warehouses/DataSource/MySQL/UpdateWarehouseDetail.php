<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

/**
 * Realiza una actualización al dato de la cantidad de producto existente
 * en un almacén.
 */
class UpdateWarehouseDetail
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Actualiza la cantidad de producto existente en un almacén.
     *
     * Advertencia: los datos deberán llegar ya validados en este punto.
     *
     * @param $data
     *
     * @return bool
     */
    public function write($data)
    {
        return $this->connection->execute('UPDATE DetalleAlmacenes SET Cantidad = :cantidadIngreso WHERE AlmacenID = :almacenID AND ProductoID = :productoID', $data);
    }
}