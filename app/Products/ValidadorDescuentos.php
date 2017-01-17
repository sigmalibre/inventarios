<?php

namespace Sigmalibre\Products;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\Length;
use Respect\Validation\Rules\Min;
use Respect\Validation\Rules\Numeric;
use Respect\Validation\Rules\StringType;
use Sigmalibre\Validation\Validator;

/**
 * Raliza validaciones para los datos de un descuento de producto.
 */
class ValidadorDescuentos extends Validator
{
    /**
     * Realiza las validaciones necesarias para cada caso en específico.
     * Los campos que no pasen la validación deberán ser todos guardados en
     * $invalidUserInputs.
     *
     * @param array $input
     *
     * @return bool True si todos los validadores pasaron la prueba; False sino
     */
    public function validate($input)
    {
        $this->validarRazon($input);
        $this->validarCantidad($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * La razón del descuento debe ser un string de 1 a 45 carácteres.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarRazon($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 45, true)
        );

        if ($v->validate($input['razonDescuento']) === false) {
            $this->setInvalidInput('razonDescuento');

            return false;
        }

        return true;
    }

    /**
     * La cantidad descontada debe ser un valor numérico mayor de cero.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarCantidad($input)
    {
        $v = new AllOf(
            new Numeric(),
            new Min(0.0001, true)
        );

        if ($v->validate($input['cantidadDescontada']) === false) {
            $this->setInvalidInput('cantidadDescontada');

            return false;
        }

        return true;
    }
}