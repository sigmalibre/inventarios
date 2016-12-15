<?php

namespace Sigmalibre\UnitsOfMeasurement\DataSource\MySQL;

/**
 * Actualiza las unidades de medida en la BD.
 */
class UpdateUnit
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
        return $this->connection->execute('UPDATE Medidas SET UnidadMedida = :unidadMedida WHERE Medidas.MedidaID = :id', $dataList);
    }
}
