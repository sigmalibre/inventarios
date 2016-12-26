<?php

namespace Sigmalibre\Brands\DataSource\MySQL;

/**
 * Actualiza marcas de producto en la BD
 */
class UpdateBrand
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
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
        return $this->connection->execute('UPDATE Marcas SET Nombre = :nombreMarca WHERE Marcas.MarcaID = :id', $dataList);
    }
}
