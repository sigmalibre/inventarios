<?php

namespace Sigmalibre\Empresas\DataSource;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

/**
 * Actualiza un registro de empresa en la BD.
 */
class UpdateEmpresa
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Actualiza los datos de un registro de empresa en la BD.
     *
     * Advertencia: todos los datos para la actualización deberán llegar validados en este punto.
     *
     * @param $data
     *
     * @return bool
     */
    public function write($data)
    {
        return $this->connection->execute('UPDATE Empresas SET NombreComercial = :nombreComercial, RazonSocial = :razonSocial, Giro = :giro, Registro = :registro, NIT = :nit WHERE EmpresaID = :id', $data);
    }
}