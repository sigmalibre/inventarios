<?php

namespace Sigmalibre\Categories\DataSource\MySQL;

/**
 * Obtiene la lista con las categorías existentes.
 */
class SearchAllCategories implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL($container);
    }

    public function read($pagination)
    {
        $statement = 'SELECT codigo_cat, nombre_cat FROM tbcategoriaproductos LIMIT :offset, :items';

        $params[':offset'] = $options['offset'];
        $params[':items'] = $options['items'];

        return $this->connection->query($statement, $params);
    }
}
