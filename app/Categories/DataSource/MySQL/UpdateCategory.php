<?php

namespace Sigmalibre\Categories\DataSource\MySQL;

/**
 * Realiza un UPDATE de una categoría de producto específica según su código.
 */
class UpdateCategory
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL\MySQL($container);
    }

    /**
     * Ejecuta el query de UPDATE según los nuevos datos que nos haya pasado el usuario.
     *
     * Advertencia: todos los inputs para la actualización ya deberían llegar validados en este punto.
     *
     * @param array $dataList Lista con los datos a actualizar
     *
     * @return bool True si se pudo actualizar; False de lo contrario
     */
    public function write($dataList)
    {
        return $this->connection->execute('UPDATE CategoriaProductos SET CategoriaProductoID = :codigoCategoria, Nombre = :nombreCategoria WHERE CategoriaProductos.CategoriaProductoID = :id', $dataList);
    }
}
