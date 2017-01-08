<?php

namespace Sigmalibre\Warehouses;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\IntVal;
use Respect\Validation\Rules\Min;
use Respect\Validation\Rules\Numeric;
use Sigmalibre\Validation\Validator;

/**
 * Realiza validaciones para los detalles de los almacenes de producto.
 */
class WarehouseDetailValidator extends Validator
{
    /**
     * Realiza las validaciones específicas para crear y modificar un detalle de almacén.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validate($input)
    {
        $this->validarCantidad($input);
        $this->validarAlmacenID($input);
        $this->validarProductoID($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * La cantidad del detalle debe ser un valor numérico entero.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validarCantidad(array $input)
    {
        $v = new AllOf(
            new Numeric(),
            new IntVal()
        );

        if ($v->validate($input['cantidadIngreso']) === false) {
            $this->setInvalidInput('cantidadIngreso');

            return false;
        }

        return true;
    }

    /**
     * La ID del almacén es un número entero positivo.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validarAlmacenID(array $input)
    {
        $v = new AllOf(
            new Numeric(),
            new IntVal(),
            new Min(1, true)
        );

        if ($v->validate($input['almacenID']) === false) {
            $this->setInvalidInput('almacenID');

            return false;
        }

        return true;
    }

    public function validarProductoID(array $input)
    {
        $v = new AllOf(
            new Numeric(),
            new IntVal(),
            new Min(1, true)
        );

        if ($v->validate($input['productoID']) === false) {
            $this->setInvalidInput('productoID');

            return false;
        }

        return true;
    }
}