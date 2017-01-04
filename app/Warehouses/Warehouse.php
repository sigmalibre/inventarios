<?php

namespace Sigmalibre\Warehouses;
use Sigmalibre\Warehouses\DataSource\MySQL\GetWarehouseFromID;
use Sigmalibre\Warehouses\DataSource\MySQL\UpdateWarehouse;

/**
 * Modelo para operaciones sobre un almacén.
 */
class Warehouse
{
    private $container;
    private $validator;
    private $attributes;
    private $dataSource;

    public function __construct($id, $container)
    {
        $this->container = $container;
        $this->validator = new WarehousesValidator();
        $this->dataSource = new GetWarehouseFromID($container);

        $this->init($id);
    }

    /**
     * Inicializa los datos de un almacén a partir de su ID.
     *
     * @param $id
     */
    public function init($id)
    {
        $this->attributes = $this->dataSource->read([
            'input' => [
                'idAlmacen' => $id,
            ],
        ]);
    }

    /**
     * Comprueba si se pudo crear el objeto de forma correcta.
     *
     * @return bool
     */
    public function is_set()
    {
        return isset($this->attributes[0]);
    }

    public function getID()
    {
        return $this->attributes[0]['AlmacenID'];
    }

    public function getNombre()
    {
        return $this->attributes[0]['NombreAlmacen'];
    }

    private function setNombre(string $nombre)
    {
        $this->attributes[0]['NombreAlmacen'] = $nombre;
    }

    /**
     * Actualiza la fuente de datos sobre la información de este objeto.
     *
     * @param array $userInput
     *
     * @return bool
     */
    public function update(array $userInput)
    {
        // Limpiar los espacios en blanco al inicio y final de todos los inputs.
        $userInput = array_map('trim', $userInput);

        // Validar el input del usuario.
        if ($this->validator->validate($userInput) === false) {
            return false;
        }

        $userInput['id'] = $this->getID();

        $writer = new UpdateWarehouse($this->container);

        $isSaved = $writer->write($userInput);

        if ($isSaved === false) {
            return false;
        }

        $this->setNombre($userInput['nombreAlmacen']);

        return true;
    }

    /**
     * Obtiene la lista de los inputs que no pasaron la validación al actualizar el almacén.
     *
     * @return array
     */
    public function getInvalidInputs()
    {
        return $this->validator->getInvalidInputs();
    }
}