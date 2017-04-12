<?php

namespace Sigmalibre\Warehouses;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewDireccion;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewTelefono;
use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateDireccionAlmacen;
use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateTelefonoAlmacen;
use Sigmalibre\DatosGenerales\Direccion;
use Sigmalibre\DatosGenerales\Telefono;
use Sigmalibre\DatosGenerales\ValidadorDireccion;
use Sigmalibre\DatosGenerales\ValidadorTelefono;
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
    /** @var MySQLTransactions $transaction */
    private $transaction;

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
        $this->transaction = $container->mysql;
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
                'idAlmacen' => empty($id) ? -1 : $id,
            ],
        ]);

        if ($attributes === false) {
            return false;
        }

        $this->id = $id ?? null;
        $this->nombre = $attributes[0]['NombreAlmacen'] ?? null;
        $this->direccion = $attributes[0]['Direccion'] ?? null;
        $this->telefono = $attributes[0]['Telefono'] ?? null;
        $this->cantidad = $attributes[0]['Cantidad'] ?? null;

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

        $this->transaction->beginTransaction();

        $isWarehouseUpdated = $this->updateWarehouse($input['nombreAlmacen']);

        if ($isWarehouseUpdated === false) {
            $this->transaction->rollBack();

            return false;
        }

        $isDirectionUpdated = $this->updateDireccion($input['direccion']);
        $isTelefonoUpdated = $this->updateTelefono($input['telefono']);

        if ($isDirectionUpdated === false || $isTelefonoUpdated === false) {
            $this->transaction->rollBack();

            return false;
        }

        $this->transaction->commit();

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

    /**
     * Actualiza la dirección de este almacén y la crea si no existe.
     *
     * @param $direccion
     *
     * @return bool
     */
    private function updateDireccion($direccion)
    {
        if (isset($this->direccion) === false) {
            $is_saved = (new Direccion())->save(new SaveNewDireccion($this->container), $direccion, ['almacenID' => $this->id]);

            if ($is_saved === false) {
                return false;
            }

            $this->direccion = $direccion;

            return true;
        }

        $is_updated = (new Direccion())->save(new UpdateDireccionAlmacen($this->container), $direccion, ['almacenID' => $this->id]);

        if ($is_updated === false) {
            return false;
        }

        $this->direccion = $direccion;

        return true;
    }

    /**
     * Actualiza el teléfono de este almacén y lo crea si no existe.
     *
     * @param $telefono
     *
     * @return bool
     */
    private function updateTelefono($telefono)
    {
        if (isset($this->telefono) === false) {
            $is_saved = (new Telefono())->save(new SaveNewTelefono($this->container), $telefono, ['almacenID' => $this->id]);

            if ($is_saved === false) {
                return false;
            }

            $this->telefono = $telefono;

            return true;
        }

        $is_updated = (new Telefono())->save(new UpdateTelefonoAlmacen($this->container), $telefono, ['almacenID' => $this->id]);

        if ($is_updated === false) {
            return false;
        }

        $this->telefono = $telefono;

        return true;
    }
}