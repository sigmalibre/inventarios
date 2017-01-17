<?php

namespace Sigmalibre\Products\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\DataSource\WriteInterface;

/**
 * Elimina un registrode descuento de la BD.
 */
class DeleteDescuento implements WriteInterface
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Elimina un registro de un descuento de la BD.
     *
     * @param $data
     *
     * @return bool
     */
    public function write($data)
    {
        return $this->connection->execute('DELETE FROM Descuentos WHERE DescuentoID = :descuentoID AND ProductoID = :productoID', $data);
    }
}