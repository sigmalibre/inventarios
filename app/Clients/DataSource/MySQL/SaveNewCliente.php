<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

/**
 * Guarda un cliente nuevo en la BD.
 */
class SaveNewCliente
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Guarda un cliente nuevo en la BD.
     *
     * Advertencia: los datos para crear al cliente ya deberán llegar validados aquí.
     *
     * @param $data
     *
     * @return bool|string
     */
    public function write($data)
    {
        $isSaved = $this->connection->execute('INSERT INTO ClientesPersonas (Nombres, Apellidos, DUI, NIT) VALUES (:nombres, :apellidos, :dui, :nit)', $data);
        if ($isSaved === false) {
            return false;
        }

        return $this->connection->lastId();
    }
}