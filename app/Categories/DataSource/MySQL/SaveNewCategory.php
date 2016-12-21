<?php

namespace Sigmalibre\Categories\DataSource\MySQL;

/**
 * Inserción de categorías nuevas a la BD.
 */
class SaveNewCategory
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL\MySQL($container);
    }

    /**
     * Guarda una nueva categoría en la BD MySQL.
     *
     * Advertencia: Todos los datos para la creación de una nueva categoría deberían llegar validados en este punto.
     *
     * @param array $newDataList Lista con los datos necesarios para crear una categoría
     *
     * @return bool True si se pudo crear la categoría; False de lo contrario
     */
    public function write($newDataList)
    {
        $isSaved = $this->connection->execute('INSERT INTO CategoriaProductos (CategoriaProductoID, Nombre) VALUES (:codigoCategoria, :nombreCategoria)', $newDataList);

        if ($isSaved === false) {
            return false;
        }

        return $newDataList['codigoCategoria'];
    }
}
