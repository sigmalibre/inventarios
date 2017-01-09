<?php

namespace Sigmalibre\DatosGenerales\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\DataSource\WriteInterface;

/**
 * Actualiza un correo electrónico de una empresa.
 */
class UpdateEmailEmpresa implements WriteInterface
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Raliza una actualización del email de una empresa.
     *
     * @param $data
     *
     * @return bool
     */
    public function write($data)
    {
        return $this->connection->execute('UPDATE Emails SET Email = :email WHERE EmpresaID = :empresaID', [
            'email' => $data['email'],
            'empresaID' => $data['empresaID'],
        ]);
    }
}