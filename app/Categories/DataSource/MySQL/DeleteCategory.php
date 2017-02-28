<?php

namespace Sigmalibre\Categories\DataSource\MySQL;

class DeleteCategory
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($id)
    {
        return $this->connection->execute('DELETE FROM CategoriaProductos WHERE CategoriaProductoID = :id', [
            'id' => $id,
        ]);
    }
}