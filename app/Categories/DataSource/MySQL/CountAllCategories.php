<?php

namespace Sigmalibre\Categories\DataSource\MySQL;

/**
 * Consulta la BD para saber la cantidad total de categorías de productos.
 */
class CountAllCategories implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($identifiers)
    {
        $statement = 'SELECT COUNT(*) as cuenta FROM tbcategoriaproductos';

        return $this->connection->query($statement, []);
    }
}
