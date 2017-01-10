<?php

namespace Sigmalibre\Warehouses;

use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewDireccion;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewTelefono;
use Sigmalibre\DatosGenerales\Direccion;
use Sigmalibre\DatosGenerales\Telefono;
use Sigmalibre\DatosGenerales\ValidadorDireccion;
use Sigmalibre\DatosGenerales\ValidadorTelefono;
use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\Pagination\Paginator;
use Sigmalibre\Products\Product;
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
    private $validadorDetalleAlmacen;

    public function __construct($container)
    {
        $this->container = $container;
        $this->validator = new WarehousesValidator();
        $this->validadorDirecciones = new ValidadorDireccion();
        $this->validadorTelefonos = new ValidadorTelefono();
        $this->validadorDetalleAlmacen = new WarehouseDetailValidator();
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
     * Traslada una cantidad de producto entre dos almacenes.
     *
     * @param $input
     *
     * @return bool
     */
    public function traslado($input)
    {
        // Limpiar los espacios en blanco al inicio y final de todos los inputs.
        $input = array_map('trim', $input);

        $producto = new Product($input['productoID'], $this->container);
        $almacenDesde = new Warehouse($input['almacenDesdeID'], $this->container);
        $almacenHasta = new Warehouse($input['almacenHastaID'], $this->container);

        if ($producto->is_set() === false) {
            $this->validator->setInvalidInput('productoID');
        }

        if ($almacenDesde->is_set() === false) {
            $this->validator->setInvalidInput('almacenDesdeID');
        }

        if ($almacenHasta->is_set() === false) {
            $this->validator->setInvalidInput('almacenHastaID');
        }

        $this->validadorDetalleAlmacen->validarCantidad($input);

        if ($input['cantidadIngreso'] < 0) {
            $this->validator->setInvalidInput('cantidadMenorCero');

            return false;
        }

        if (empty($this->getInvalidInputs()) === false) {
            return false;
        }

        $warehouseDetail = new WarehouseDetail($this->container);

        $cantidad_desde = $this->getCantidadDetalleAlmacen([
            'almacenID' => $input['almacenDesdeID'],
            'productoID' => $input['productoID'],
        ], $warehouseDetail);

        $cantidad_hasta = $this->getCantidadDetalleAlmacen([
            'almacenID' => $input['almacenHastaID'],
            'productoID' => $input['productoID'],
        ], $warehouseDetail);

        $cantidad_desde_total = $cantidad_desde - (int)$input['cantidadIngreso'];
        $cantidad_hasta_total = $cantidad_hasta + (int)$input['cantidadIngreso'];

        if ($cantidad_desde_total < 0) {
            $this->validator->setInvalidInput('cantidadAlmacenDesdeMenorCero');

            return false;
        }

        $this->container->mysql->beginTransaction();

        $isDetalleDesdeSaved = $warehouseDetail->update([
            'cantidadIngreso' => $cantidad_desde_total,
            'almacenID' => $input['almacenDesdeID'],
            'productoID' => $input['productoID'],
        ]);

        $isDetalleHastaSaved = $warehouseDetail->update([
            'cantidadIngreso' => $cantidad_hasta_total,
            'almacenID' => $input['almacenHastaID'],
            'productoID' => $input['productoID'],
        ]);

        if ($isDetalleDesdeSaved === false || $isDetalleHastaSaved === false) {
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
            $this->validadorTelefonos->getInvalidInputs(),
            $this->validadorDetalleAlmacen->getInvalidInputs()
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

    /**
     * Obtiene la cantidad de producto en un detalle de almacén.
     *
     * @param                                        $input
     * @param \Sigmalibre\Warehouses\WarehouseDetail $warehouseDetail
     *
     * @return int
     */
    public function getCantidadDetalleAlmacen($input, WarehouseDetail $warehouseDetail): int
    {
        // Se necesita obtener la cantidad de productos en el almacén porque es necesario comprobar que
        // la cantidad introducida por el cliente más la cantidad existente en almacén no sea menor que cero.
        $datosDetalleAlmacen = $warehouseDetail->getDetailFromParentsID([
            'almacenID' => $input['almacenID'],
            'productoID' => $input['productoID'],
        ]);

        // Si no se encuentra la información el valor por defecto es cero (no existen productos en ese almacén).
        $cantidadDetalleAlmacen = $datosDetalleAlmacen ? (int)$datosDetalleAlmacen['Cantidad'] : 0;

        return $cantidadDetalleAlmacen;
    }
}
