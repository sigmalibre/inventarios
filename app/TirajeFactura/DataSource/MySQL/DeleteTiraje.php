<?php
namespace Sigmalibre\TirajeFactura\DataSource\MySQL;

class DeleteTiraje
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($id)
    {
        return $this->connection->execute('DELETE FROM TirajeFacturas WHERE TirajeFacturaID = :id', [
            'id' => $id,
        ]);
    }
}
