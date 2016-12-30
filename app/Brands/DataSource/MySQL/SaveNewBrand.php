<?php

namespace Sigmalibre\Brands\DataSource\MySQL;

/**
 * Esta clase inserta marcas de producto en la BD.
 */
class SaveNewBrand
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Guarda una marca nueva en la BD MySQL.
     *
     * Advertencia: Todos los datos para la creación de una nueva marca ya deberían llegar validados en este punto.
     *
     * @param array $newDataList Lista con los datos para crear una nueva marca
     *
     * @return bool|string Retorna la ID de la nueva marca si se pudo crear; False de lo contrario
     */
    public function write($newDataList)
    {
        $isSaved = $this->connection->execute('INSERT INTO Marcas (Nombre) VALUES (:nombreMarca);', $newDataList);

        if ($isSaved === false) {
            return false;
        }

        return $this->connection->lastId();
    }
}
