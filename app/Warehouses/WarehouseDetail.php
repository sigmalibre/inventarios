<?php

namespace Sigmalibre\Warehouses;

use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\Pagination\Paginator;
use Sigmalibre\Warehouses\DataSource\MySQL\CountFilteredWarehouseDetails;
use Sigmalibre\Warehouses\DataSource\MySQL\FilterWarehouseDetails;
use Sigmalibre\Warehouses\DataSource\MySQL\SaveNewWarehouseDetail;
use Sigmalibre\Warehouses\DataSource\MySQL\UpdateWarehouseDetail;

/**
 * Modelo para operaciones sobre detalles de almacenes.
 */
class WarehouseDetail
{
    protected $container;
    protected $validator;

    /**
     * WarehouseDetail constructor.
     *
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
        $this->validator = new WarehouseDetailValidator();
    }

    /**
     * Realiza una lectura de los detalles de almacén existentes.
     *
     * @param array $input
     *
     * @return array
     */
    public function readList(array $input)
    {
        $listReader = new ItemListReader(
            new CountFilteredWarehouseDetails($this->container),
            new FilterWarehouseDetails($this->container),
            new Paginator($input),
            $input
        );

        $itemList = $listReader->read();
        $itemList['userInput'] = $input;

        return $itemList;
    }

    /**
     * Guarda un nuevo detalle de almacén en la fuente de datos.
     *
     * @param $input
     *
     * @return bool|string
     */
    public function save($input)
    {
        // Limpiar espacios en blanco del input
        $input = array_map('trim', $input);

        if ($this->validator->validate($input) === false) {
            return false;
        }

        $writer = new SaveNewWarehouseDetail($this->container);

        return $writer->write($input);
    }

    /**
     * Actualiza la cantidad de producto en un almacén en la fuente de datos.
     *
     * @param $input
     *
     * @return bool
     */
    public function update($input)
    {
        // Revisar si existe un registro
        $warehouseDetail = $this->getDetailFromParentsID($input);

        // Si el registro no existe, crearlo.
        if ($warehouseDetail === false) {
            return (bool) $this->save($input);
        }

        // Limpiar los espacios en blanco del input
        $input = array_map('trim', $input);

        if ($this->validator->validate($input) === false) {
            return false;
        }

        $writer = new UpdateWarehouseDetail($this->container);

        return $writer->write($input);
    }

    /**
     * Obtiene los inputs que no pasaron la validación.
     *
     * @return array
     */
    public function getInvalidInputs()
    {
        return $this->validator->getInvalidInputs();
    }

    /**
     * Obtiene el registro desde la fuente de datos sobre un detalle de almacén único, encontrado por las IDs de
     * almacén y producto.
     *
     * @param $input
     *
     * @return array|bool
     */
    public function getDetailFromParentsID($input)
    {
        $warehouseDetail = $this->readList([
            'almacenID' => $input['almacenID'],
            'productoID' => $input['productoID'],
        ]);

        return $warehouseDetail['itemList'][0] ?? false;
    }
}