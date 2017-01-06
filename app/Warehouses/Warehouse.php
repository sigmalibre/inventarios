<?php

namespace Sigmalibre\Warehouses;

use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateDireccionAlmacen;
use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateTelefonoAlmacen;
use Sigmalibre\DatosGenerales\Direccion;
use Sigmalibre\DatosGenerales\Telefono;
use Sigmalibre\Validation\ValidadorDireccion;
use Sigmalibre\Validation\ValidadorTelefono;
use Sigmalibre\Warehouses\DataSource\MySQL\GetWarehouseFromID;
use Sigmalibre\Warehouses\DataSource\MySQL\UpdateWarehouse;

/**
 * Modelo para operaciones sobre un almacén.
 */
class Warehouse
{
    private $container;
    private $validator;
    private $validadorDirecciones;
    private $validadorTelefonos;

    private $id;
    private $nombre;
    private $direccion;
    private $telefono;
    private $cantidad;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function __construct($id, $container)
    {
        $this->container = $container;
        $this->validator = new WarehousesValidator();
        $this->validadorDirecciones = new ValidadorDireccion();
        $this->validadorTelefonos = new ValidadorTelefono();

        $this->init($id);
    }

    /**
     * Inicializa los datos de un almacén a partir de su ID.
     *
     * @param $id
     *
     * @return bool
     */
    public function init($id)
    {
        $dataSource = new GetWarehouseFromID($this->container);
        $attributes = $dataSource->read([
            'input' => [
                'idAlmacen' => $id,
            ],
        ]);

        if ($attributes === false) {
            return false;
        }

        $this->id = $id;
        $this->nombre = $attributes[0]['NombreAlmacen'];
        $this->direccion = $attributes[0]['Direccion'];
        $this->telefono = $attributes[0]['Telefono'];
        $this->cantidad = $attributes[0]['Cantidad'];

        return $this->is_set();
    }

    /**
     * Comprueba si se pudo crear el objeto de forma correcta.
     *
     * @return bool
     */
    public function is_set()
    {
        // Garantizar que al menos se obtiene el nombre.
        return isset($this->nombre);
    }

    /**
     * Actualiza la fuente de datos sobre la información de este objeto.
     *
     * @param array $input
     *
     * @return bool
     */
    public function update(array $input)
    {
        // Limpiar los espacios en blanco al inicio y final de todos los inputs.
        $input = array_map('trim', $input);

        // Validar el input del usuario.
        $isInputValid = $this->runValidators($input);
        if ($isInputValid === false) {
            return false;
        }

        $this->container->mysql->beginTransaction();

        $isWarehouseUpdated = $this->updateWarehouse($input['nombreAlmacen']);

        if ($isWarehouseUpdated === false) {
            $this->container->mysql->rollBack();

            return false;
        }

        $isDirectionUpdated = (new Direccion())->save(new UpdateDireccionAlmacen($this->container), $input['direccion'], ['almacenID' => $this->id]);
        $isTelefonoUpdated = (new Telefono())->save(new UpdateTelefonoAlmacen($this->container), $input['telefono'], ['almacenID' => $this->id]);

        if ($isDirectionUpdated === false || $isTelefonoUpdated === false) {
            $this->container->mysql->rollBack();

            return false;
        }

        $this->container->mysql->commit();

        $this->init($this->id);

        return true;
    }

    private function updateWarehouse($name)
    {
        $writer = new UpdateWarehouse($this->container);

        return $writer->write([
            'nombreAlmacen' => $name,
            'id' => $this->id,
        ]);
    }

    public function runValidators(array $input)
    {
        $this->validator->validate($input);
        $this->validadorDirecciones->validate($input);
        $this->validadorTelefonos->validate($input);

        return empty($this->getInvalidInputs());
    }

    /**
     * Obtiene la lista de los inputs que no pasaron la validación al actualizar el almacén.
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
}