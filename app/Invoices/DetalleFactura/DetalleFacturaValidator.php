<?php

namespace Sigmalibre\Invoices\DetalleFactura;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\IntVal;
use Respect\Validation\Rules\Min;
use Respect\Validation\Rules\Numeric;
use Respect\Validation\Rules\Positive;
use Sigmalibre\Validation\Validator;

class DetalleFacturaValidator extends Validator
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
        $this->validarID($input);
        $this->validarCantidad($input);
        $this->validarPrecio($input);
        $this->validarProductoID($input);
        $this->validarFacturaID($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * La ID debe ser un valor entero positivo.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarID($input)
    {
        $v = new AllOf(
            new IntVal(),
            new Min(0, true)
        );

        if ($v->validate($input['detalleID']) === false) {
            $this->setInvalidInput('detalleID');

            return false;
        }

        return true;
    }

    /**
     * La cantidad debe ser un valor entero.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarCantidad($input)
    {
        $v = new IntVal();

        if ($v->validate($input['cantidad']) === false) {
            $this->setInvalidInput('cantidad');

            return false;
        }

        return true;
    }

    /**
     * El precio debe ser un valor numérico positivo.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarPrecio($input)
    {
        $v = new AllOf(
            new Numeric(),
            new Min(0, true)
        );

        if ($v->validate($input['precio']) === false) {
            $this->setInvalidInput('precio');

            return false;
        }

        return true;
    }

    /**
     * La id del producto asociado con el detalle de la factura
     * debe ser un valor entero positivo.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarProductoID($input)
    {
        $v = new AllOf(
            new IntVal(),
            new Positive()
        );

        if ($v->validate($input['productoID']) === false) {
            $this->setInvalidInput('productoID');

            return false;
        }

        return true;
    }

    /**
     * La ID de la factura a la que pertenece el detalle debe ser un valor
     * entero positivo.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarFacturaID($input)
    {
        $v = new AllOf(
            new IntVal(),
            new Min(0, true)
        );

        if ($v->validate($input['facturaID']) === false) {
            $this->setInvalidInput('facturaID');

            return false;
        }

        return true;
    }
}