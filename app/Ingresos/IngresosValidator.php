<?php

namespace Sigmalibre\Ingresos;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\IntVal;
use Respect\Validation\Rules\Min;
use Respect\Validation\Rules\Numeric;
use Respect\Validation\Rules\Optional;
use Respect\Validation\Rules\Positive;
use Sigmalibre\Validation\Validator;

/**
 * Validación para campos de ingreso de productos.
 */
class IngresosValidator extends Validator
{
    /**
     * Realiza las validaciones necesarias para cada caso en específico.
     * Los campos que no pasen la validación deberán ser todos guardados en
     * $invalidUserInputs.
     *
     * @return bool True si todos los validadores pasaron la prueba; False sino
     */
    public function validate($input)
    {
        $this->validarCantidadUnidades($input);
        $this->validarPrecioUnitario($input);
        $this->validarCostoActualTotal($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * La cantidad de be ser un valor numérico.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validarCantidadUnidades($input)
    {
        $v = new AllOf(
            new Numeric()
        );

        if ($v->validate($input['cantidadIngreso']) === false) {
            $this->setInvalidInput('cantidadIngreso');

            return false;
        }

        return true;
    }

    /**
     * El valor del precio unitario debe ser un número positivo.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validarPrecioUnitario($input)
    {
        $v = new AllOf(
            new Numeric(),
            new Min(0, true)
        );

        if ($v->validate($input['valorPrecioUnitario']) === false) {
            $this->setInvalidInput('valorPrecioUnitario');

            return false;
        }

        return true;
    }

    /**
     * El costo total debe ser un número positivo.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validarCostoActualTotal($input)
    {
        $v = new AllOf(
            new Numeric(),
            new Min(0, true)
        );

        if ($v->validate($input['valorCostoActualTotal']) === false) {
            $this->setInvalidInput('valorCostoActualTotal');

            return false;
        }

        return true;
    }

    /**
     * La ID del producto debe ser un número entero positivo.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validarIDProducto($input)
    {
        $v = new AllOf(
            new Numeric(),
            new Positive(),
            new IntVal()
        );

        if ($v->validate($input['productoID']) === false) {
            $this->setInvalidInput('productoID');

            return false;
        }

        return true;
    }

    /**
     * La ID de la empresa debe ser un número entero positivo. Opcional.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validarIDEmpresa($input)
    {
        $v = new AllOf(
            new Optional(new Numeric()),
            new Optional(new Positive()),
            new Optional(new IntVal())
        );

        if ($v->validate($input['empresaID']) === false) {
            $this->setInvalidInput('empresaID');

            return false;
        }

        return true;
    }
}