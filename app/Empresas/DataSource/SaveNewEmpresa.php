<?php

namespace Sigmalibre\Empresas\DataSource;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

/**
 * Guarda un nuevo registro de Empresa en la BD.
 */
class SaveNewEmpresa
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Escribe en la BD un nuevo registro de empresa.
     *
     * Advertencia: todos los datos deberán llegar validados en este punto.
     *
     * @param $data
     *
     * @return bool|string
     */
    public function write($data)
    {
        $isSaved = $this->connection->execute('INSERT INTO Empresas (NombreComercial, RazonSocial, Giro, Registro, NIT) VALUES (:nombreComercial, :razonSocial, :giro, :registro, :nit)', $data);

        if ($isSaved === false) {
            return false;
        }

        return $this->connection->lastId();
    }
}