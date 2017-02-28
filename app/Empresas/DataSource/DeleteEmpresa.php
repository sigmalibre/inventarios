<?php

namespace Sigmalibre\Empresas\DataSource;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

class DeleteEmpresa
{
    /** @var MySQLTransactions */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($id)
    {
        return $this->connection->execute('DELETE FROM Empresas WHERE EmpresaID = :id', [
            'id' => $id,
        ]);
    }
}
