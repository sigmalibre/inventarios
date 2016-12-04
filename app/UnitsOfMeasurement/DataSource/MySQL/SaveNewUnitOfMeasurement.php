<?php

namespace Sigmalibre\UnitsOfMeasurement\DataSource\MySQL;

/**
 * Esta clase inserta unidades de medida de producto en la BD.
 */
class SaveNewUnitOfMeasurement
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL\MySQL($container);
    }

    /**
     * Guarda una unidad de medida nueva en la BD MySQL.
     *
     * Advertencia: Todos los datos para la creación de una nueva unidad de medida ya deberían llegar validados en este punto.
     *
     * @param array $newDataList Lista con los datos para crear una nueva unidad de medida
     *
     * @return bool|string Retorna la ID de la nueva unidad de medida si se pudo crear; False de lo contrario
     */
    public function write($newDataList)
    {
        $isSaved = $this->connection->execute('INSERT INTO Medidas (UnidadMedida) VALUES (:unidadMedida)', $newDataList);

        if ($isSaved === false) {
            return false;
        }

        return $this->connection->lastId();
    }
}
