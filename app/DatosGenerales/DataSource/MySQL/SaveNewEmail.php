<?php

namespace Sigmalibre\DatosGenerales\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\DataSource\WriteInterface;

/**
 * Guarda un nuevo correo electrónico en la BD.
 */
class SaveNewEmail implements WriteInterface
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Guarda un nuevo correo electrónico en la BD.
     *
     * Advertencia: los datos para la creación del correo electrónico deben estar validados en este punto.
     *
     * @param $data
     *
     * @return bool|string
     */
    public function write($data)
    {
        $isSaved = $this->connection->execute('INSERT INTO Emails (Email, EmpresaID, EmpleadoID) VALUES (:email, :empresaID, :empleadoID)', $data);

        if ($isSaved === false) {
            return false;
        }

        return $this->connection->lastId();
    }
}