<?php

namespace Sigmalibre\Products\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\DataSource\WriteInterface;

/**
 * Actualiza un registro de un descuento de producto en la BD.
 */
class UpdateDescuento implements WriteInterface
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Realiza la actualización de los datos de un descuento en la BD.
     *
     * Advertencia: los datos deberán llegar ya validados.
     *
     * @param $data
     *
     * @return bool
     */
    public function write($data)
    {
        return $this->connection->execute('UPDATE Descuentos SET RazonDescuento = :razonDescuento, CantidadDescontada = :cantidadDescontada WHERE DescuentoID = :descuentoID AND ProductoID = :productoID', $data);
    }
}