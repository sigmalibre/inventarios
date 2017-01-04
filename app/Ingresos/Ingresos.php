<?php

namespace Sigmalibre\Ingresos;

use Sigmalibre\Ingresos\DataSource\MySQL\CountFilteredIngresos;
use Sigmalibre\Ingresos\DataSource\MySQL\FilterIngresos;
use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\Pagination\Paginator;
use Sigmalibre\Products\Product;
use Sigmalibre\Products\Products;
use Slim\Container;

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
     * @param $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->validator = new IngresosValidator();
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
        $input = $this->products->parseCodigoConCategoria($input);

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
     * @param array $userInput
     * @param       $id
     *
     * @return bool
     */
    public function save($userInput, $id)
    {
        // Limpiar los espacios en blanco al inicio y final de todos los inputs.
        $userInput = array_map('trim', $userInput);

        $userInput['productoID'] = $id;

        // Ya que el campo de EmpresaID en la fuente de datos solo acepta INT y NULL, si se pasa un
        // string vacío, se convierte a NULL en su lugar.
        $userInput['empresaID'] = empty($userInput['empresaID']) ? null : $userInput['empresaID'];

        // Si el nuevo costo total del producto no viene establecido en el input, calcularlo a partir
        // del método del promedio ponderado.
        if (empty($userInput['valorCostoActualTotal']) === true) {
            $producto = new Product($userInput['productoID'], $this->container);
            $promediador = new PromedioPonderado($producto, $userInput);
            $userInput['valorCostoActualTotal'] = $promediador->calcularNuevoCosto();
        }

        // Validar el input del usuario.
        if ($this->validator->validate($userInput) === false) {
            return false;
        }

        $writer = new DataSource\MySQL\SaveNewIngreso($this->container);

        return $writer->write($userInput);
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