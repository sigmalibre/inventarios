<?php

namespace Sigmalibre\Clients\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

/**
 * Actualiza un registro de un cliente en la BD.
 */
class UpdateCliente
{
    /** @var MySQLTransactions $connection */
    public $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($data)
    {
        return $this->connection->execute('UPDATE ClientesPersonas SET Nombres = :nombres, Apellidos = :apellidos, DUI = :dui, NIT = :nit WHERE ClientesPersonasID = :id', $data);
    }
}