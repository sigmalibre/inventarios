<?php

namespace Sigmalibre\Warehouses;

use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewDireccion;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewTelefono;
use Sigmalibre\DatosGenerales\Direccion;
use Sigmalibre\DatosGenerales\Telefono;
use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\Pagination\Paginator;
use Sigmalibre\Validation\ValidadorDireccion;
use Sigmalibre\Validation\ValidadorTelefono;
use Sigmalibre\Warehouses\DataSource\MySQL\SaveNewWarehouse;
use Sigmalibre\Warehouses\DataSource\MySQL\SearchAllWarehouses;

/**
 * Modelo para las operaciones CRUD sobre las bodegas.
 */
class Warehouses
{
    private $container;
    private $validator;
    private $validadorDirecciones;
    private $validadorTelefonos;

    public function __construct($container)
    {
        $this->container = $container;
        $this->validator = new WarehousesValidator();
        $this->validadorDirecciones = new ValidadorDireccion();
        $this->validadorTelefonos = new ValidadorTelefono();
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
     * @param array $input
     *
     * @return bool
     */
    public function save(array $input)
    {
        // Limpiar los espacios en blanco al inicio y final de todos los inputs.
        $input = array_map('trim', $input);

        // Validar el input del usuario.
        $isInputValid = $this->runValidators($input);
        if ($isInputValid === false) {
            return false;
        }

        $this->container->mysql->beginTransaction();

        $newWarehouseID = $this->saveWarehouse($input['nombreAlmacen']);

        if ($newWarehouseID === false) {
            $this->container->mysql->rollBack();

            return false;
        }

        $newDireccionID = (new Direccion())->save(new SaveNewDireccion($this->container), $input['direccion'], ['almacenID' => $newWarehouseID]);
        $newTelefonoID = (new Telefono())->save(new SaveNewTelefono($this->container), $input['telefono'], ['almacenID' => $newWarehouseID]);

        if ($newDireccionID === false || $newTelefonoID === false) {
            $this->container->mysql->rollBack();

            return false;
        }

        $this->container->mysql->commit();

        return true;
    }

    /**
     * Obtiene la lista con los inputs que no pasaron la validación.
     *
     * @return array
     */
    public function getInvalidInputs()
    {
        return array_merge(
            $this->validator->getInvalidInputs(),
            $this->validadorDirecciones->getInvalidInputs(),
            $this->validadorTelefonos->getInvalidInputs()
        );
    }

    /**
     * @param array $input
     *
     * @return bool
     */
    private function runValidators(array $input)
    {
        $this->validator->validate($input);
        $this->validadorDirecciones->validate($input);
        $this->validadorTelefonos->validate($input);

        return empty($this->getInvalidInputs());
    }

    /**
     * @param $name
     *
     * @return bool|string
     */
    private function saveWarehouse($name)
    {
        $warehouseWriter = new SaveNewWarehouse($this->container);

        return $warehouseWriter->write([
            'nombreAlmacen' => $name,
        ]);
    }
}
