<?php

namespace Sigmalibre\DatosGenerales\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\DataSource\WriteInterface;

/**
 * Actualiza un teléfono de una empresa.
 */
class UpdateTelefonoEmpresa implements WriteInterface
{
    /** @var MySQLTransactions */
    private $connection;

    function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Realiza la actualización de un teléfono.
     *
     * @param array $data
     *
     * @return bool
     */
    public function write($data)
    {
        return $this->connection->execute('UPDATE Telefonos SET Telefono = :telefono WHERE EmpresaID = :empresaID', [
            'telefono' => $data['telefono'],
            'empresaID' => $data['empresaID'],
        ]);
    }
}