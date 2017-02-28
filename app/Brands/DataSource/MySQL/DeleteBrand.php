<?php

namespace Sigmalibre\Brands\DataSource\MySQL;

class DeleteBrand
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($id)
    {
        return $this->connection->execute('DELETE FROM Marcas WHERE MarcaID = :id;', [
            'id' => $id,
        ]);
    }
}
