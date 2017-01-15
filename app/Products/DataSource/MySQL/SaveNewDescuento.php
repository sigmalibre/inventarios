<?php

namespace Sigmalibre\Products\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\DataSource\WriteInterface;

/**
 * Guarda un nuevo descuento de un producto en la BD.
 */
class SaveNewDescuento implements WriteInterface
{
    /** @var MySQLTransactions $connection */
    protected $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }


    /**
     * Guarda un nuevo descuento de producto en la BD.
     *
     * Advertencia: los datos para la creación de un descuento deberán llegar validados en este punto.
     *
     * @param $data
     *
     * @return bool|string
     */
    public function write($data)
    {
        $isSaved = $this->connection->execute('INSERT INTO Descuentos (RazonDescuento, CantidadDescontada, ProductoID) VALUES (:razonDescuento, :cantidadDescontada, :productoID)', $data);
        if ($isSaved === false) {
            return false;
        }

        return $this->connection->lastId();
    }
}