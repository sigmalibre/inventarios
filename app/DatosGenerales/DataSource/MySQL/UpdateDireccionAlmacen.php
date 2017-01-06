<?php

namespace Sigmalibre\DatosGenerales\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\DataSource\WriteInterface;

/**
 * Actualiza una dirección.
 */
class UpdateDireccionAlmacen implements WriteInterface
{
    /** @var MySQLTransactions */
    private $connection;

    function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Realiza la actualización de una dirección
     *
     * @param array $data
     *
     * @return bool
     */
    public function write($data)
    {
        return $this->connection->execute('UPDATE Direcciones SET Direccion = :direccion WHERE AlmacenID = :almacenID', [
            'direccion' => $data['direccion'],
            'almacenID' => $data['almacenID'],
        ]);
    }
}