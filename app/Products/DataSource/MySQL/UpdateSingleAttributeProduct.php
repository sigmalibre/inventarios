<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Realiza un update de un producto específico según su ID.
 */
class UpdateSingleAttributeProduct
{
    private $connection;
    private $columnWhiteList = ['Utilidad'];

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
        // Revisar que el attributo que ingresó el usuario esté en la WhiteList.
        if (in_array($dataList['attribute'], $this->columnWhiteList) === false) {
            return false;
        }

        return $this->connection->execute('UPDATE Productos SET '.$dataList['attribute'].' = :value WHERE Productos.ProductoID = :id', [
            'value' => $dataList['value'],
            'id' => $dataList['id'],
        ]);
    }
}
