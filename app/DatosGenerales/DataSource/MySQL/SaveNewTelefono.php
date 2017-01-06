<?php

namespace Sigmalibre\DatosGenerales\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

/**
 * Guarda nuevos teléfonos en la BD.
 */
class SaveNewTelefono
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Guarda un nuevo teléfono en la BD.
     *
     * Los datos ya deberán llegar validados en este punto.
     *
     * @param $data
     *
     * @return bool|string
     */
    public function write($data)
    {
        $isSaved = $this->connection->execute('INSERT INTO Telefonos (Telefono, EmpresaID, EmpleadoID, ClientesPersonasID, AlmacenID) VALUES (:telefono, :empresaID, :empleadoID, :clientePersonaID, :almacenID)', $data);

        if ($isSaved === false) {
            return false;
        }

        return $this->connection->lastId();
    }
}