<?php

namespace Sigmalibre\Ingresos;

use Sigmalibre\Empresas\Empresa;
use Sigmalibre\Ingresos\DataSource\MySQL\CountFilteredIngresos;
use Sigmalibre\Ingresos\DataSource\MySQL\FilterIngresos;
use Sigmalibre\Ingresos\DataSource\MySQL\GetLastFromProduct;
use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\Pagination\Paginator;
use Sigmalibre\Products\Product;
use Sigmalibre\Products\Products;
use Sigmalibre\Validation\Validator;
use Sigmalibre\Warehouses\Warehouse;
use Sigmalibre\Warehouses\WarehouseDetail;
use Sigmalibre\Warehouses\Warehouses;

/**
 * Modelo para operaciones sobre ingreso de productos.
 */
class Ingresos
{
    private $container;
    private $validator;
    private $products;

    /**
     * Ingresos constructor.
     *
     * @param                                  $container
     * @param \Sigmalibre\Validation\Validator $validator
     */
    public function __construct($container, Validator $validator = null)
    {
        $this->container = $container;
        $this->validator = $validator ?? new IngresosValidator();
        $this->products = new Products($container);
    }

    /**
     * Realiza una lectura de las entradas de producto existentes.
     *
     * @param array $input
     *
     * @return array
     */
    public function readList(array $input)
    {
        $listReader = new ItemListReader(
            new CountFilteredIngresos($this->container),
            new FilterIngresos($this->container),
            new Paginator($input),
            $input
        );

        $itemList = $listReader->read();
        $itemList['userInput'] = $input;

        return $itemList;
    }

    /**
     * Guarda un ingreso de producto nuevo en la fuente de datos.
     *
     * @param array $input
     * @param       $id
     *
     * @return bool
     */
    public function save($input, $id)
    {
        // Limpiar los espacios en blanco al inicio y final de todos los inputs.
        $input = array_map('trim', $input);

        error_log(var_export($input, true));

        $input['valorCostoActualTotal'] = $input['valorCostoActualTotal'] ?? '';

        // Validar el input del usuario.
        if ($this->validator->validate($input) === false) {
            return false;
        }

        // Revisar si el producto al que se desea hacer el ingreso existe.
        $producto = new Product($id, $this->container);

        if ($producto->is_set() === false) {
            $this->validator->setInvalidInput('productoID');

            return false;
        }

        // Revisar si el almacen al que se desea ingresar existe.
        $almacen = new Warehouse($input['almacenID'], $this->container);

        if ($almacen->is_set() === false) {
            $this->validator->setInvalidInput('almacenID');

            return false;
        }

        // Se agrega la id del producto al input porque las fuentes de datos lo necesitan.
        $input['productoID'] = $id;

        // Ya que el campo de EmpresaID en la fuente de datos solo acepta INT y NULL, si se pasa un
        // string vacío, se convierte a NULL en su lugar.
        $input['empresaID'] = empty($input['empresaID']) ? null : $input['empresaID'];
        if ($input['empresaID'] !== null) {
            $empresa = new Empresa($input['empresaID'], $this->container);

            if ($empresa->is_set() === false) {
                $this->validator->setInvalidInput('empresaID');

                return false;
            }
        }

        // Si el nuevo costo total del producto no viene establecido en el input, calcularlo a partir
        // del método del promedio ponderado.
        if (empty($input['valorCostoActualTotal']) === true) {
            $promediador = new PromedioPonderado($producto, $input);
            $input['valorCostoActualTotal'] = $promediador->calcularNuevoCosto();
        }

        $warehouses = new Warehouses($this->container);
        $warehouseDetail = new WarehouseDetail($this->container);

        $cantidadDetalleAlmacen = $warehouses->getCantidadDetalleAlmacen($input, $warehouseDetail);

        // Las devoluciones sobre compras se hacen simplemente ingresando un número negatívo como ingreso de producto
        // Y dejando el costo al mismo con el que se compró.
        // El sistema debe limitar que no se hagan ingresos negativos que pongan la cantidad de producto por debajo de 0
        $cantidad_total = $cantidadDetalleAlmacen + (int)$input['cantidadIngreso'];
        if ($cantidad_total < 0) {
            $this->validator->setInvalidInput('ingresoMenorCero');

            return false;
        }

        // Iniciar transacción
        $this->container->mysql->beginTransaction();

        $isWarehouseDetailSaved = $warehouseDetail->update([
            'cantidadIngreso' => $cantidad_total,
            'almacenID' => $input['almacenID'],
            'productoID' => $input['productoID'],
        ]);

        if ($isWarehouseDetailSaved === false) {
            $this->container->mysql->rollBack();

            return false;
        }

        $writer = new DataSource\MySQL\SaveNewIngreso($this->container);

        $isIngresoSaved = $writer->write($input);

        if ($isIngresoSaved === false) {
            $this->container->mysql->rollBack();

            return false;
        }

        $this->container->mysql->commit();

        return true;
    }

    public function lastFromProduct($productID) {
        $getLast = new GetLastFromProduct($this->container);
        $ultimo_ingreso = $getLast->read([
            'input' => [
                'productoID' => $productID ?? -1,
            ],
        ]);

        return $ultimo_ingreso;
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
}