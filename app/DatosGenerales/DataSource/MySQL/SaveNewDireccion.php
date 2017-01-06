<?php

namespace Sigmalibre\DatosGenerales\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

/**
 * Guarda una nueva dirección en la BD.
 */
class SaveNewDireccion
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Guarda una nueva dirección en la BD.
     *
     * Los datos deberán estar validados en este punto.
     *
     * @param $data
     *
     * @return bool|string
     */
    public function write($data)
    {
        $isSaved = $this->connection->execute('INSERT INTO Direcciones (Direccion, EmpresaID, EmpleadoID, ClientesPersonasID, AlmacenID) VALUES (:direccion, :empresaID, :empleadoID, :clientePersonaID, :almacenID)', $data);

        if ($isSaved === false) {
            return false;
        }

        return $this->connection->lastId();
    }
}