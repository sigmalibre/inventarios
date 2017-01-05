<?php

namespace Sigmalibre\Warehouses;

use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\Pagination\Paginator;
use Sigmalibre\Warehouses\DataSource\MySQL\SaveNewWarehouse;
use Sigmalibre\Warehouses\DataSource\MySQL\SearchAllWarehouses;

/**
 * Modelo para las operaciones CRUD sobre las bodegas.
 */
class Warehouses
{
    private $container;
    private $validator;

    public function __construct($container)
    {
        $this->container = $container;
        $this->validator = new WarehousesValidator();
    }

    /**
     * Obtiene la lista con las bodegas existentes según los términos de búsqueda
     * que aplique el usuario y con paginación.
     *
     * @param $userInput
     *
     * @return array
     */
    public function readWarehouseList($userInput)
    {
        $listReader = new ItemListReader(
            new DataSource\MySQL\CountAllFilteredWarehouses($this->container),
            new DataSource\MySQL\FilterAllWarehouses($this->container),
            new Paginator($userInput),
            $userInput
        );

        $warehouseList = $listReader->read();
        $warehouseList['userInput'] = $userInput;

        return $warehouseList;
    }

    /**
     * Obtiene todos los almacenes en existencia.
     *
     * @return array
     */
    public function readAll()
    {
        $reader = new SearchAllWarehouses($this->container);

        return $reader->read([]);
    }

    /**
     * Guarda un nuevo almacén en la fuente de datos.
     *
     * @param array $userInput
     *
     * @return bool|string
     */
    public function save(array $userInput)
    {
        // Limpiar los espacios en blanco al inicio y final de todos los inputs.
        $userInput = array_map('trim', $userInput);

        // Validar el input del usuario.
        if ($this->validator->validate($userInput) === false) {
            return false;
        }

        // Guardar el almacén.
        $writer = new SaveNewWarehouse($this->container);

        return $writer->write($userInput);
    }

    /**
     * Obtiene la lista con los inputs que no pasaron la validación.
     *
     * @return array
     */
    public function getInvalidInputs()
    {
        return $this->validator->getInvalidInputs();
    }
}
