<?php

namespace Sigmalibre\Invoices;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\IntVal;
use Respect\Validation\Rules\Min;
use Respect\Validation\Rules\Numeric;
use Respect\Validation\Rules\Optional;
use Sigmalibre\Validation\Validator;

/**
 * Validador para los datos de una factura.
 */
class ValidadorFacturas extends Validator
{
    private $validadorPositivo;

    public function __construct()
    {
        $this->validadorPositivo = new AllOf(
            new Numeric(),
            new IntVal(),
            new Min(1, true)
        );
    }

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
        $this->validarCorrelativo($input);
        $this->validarTipoFactura($input);
        $this->validarEmpleado($input);
        $this->validarTiraje($input);
        $this->validarEmpresa($input);
        $this->validarCliente($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * El correlativo debe ser un valor numérico entero positivo.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarCorrelativo($input)
    {
        if ($this->validadorPositivo->validate($input['correlativo']) === false) {
            $this->setInvalidInput('correlativo');

            return false;
        }

        return true;
    }

    /**
     * La ID del tipo de factura debe ser un valor numérico entero positivo.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarTipoFactura($input)
    {
        if ($this->validadorPositivo->validate($input['tipoFacturaID']) === false) {
            $this->setInvalidInput('tipoFacturaID');

            return false;

        }

        return true;
    }

    /**
     * La ID del empleado que hizo la factura debe ser un valor numérico entero posivo.
     * Valor opcional.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarEmpleado($input)
    {
        $v = new Optional($this->validadorPositivo);
        if ($v->validate($input['empleadoID']) === false) {
            $this->setInvalidInput('empleadoID');

            return false;
        }

        return false;
    }

    /**
     * La ID del tiraje de la factura debe ser un valor numérico entero positivo.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarTiraje($input)
    {
        if ($this->validadorPositivo->validate($input['tirajeFacturaID']) === false) {
            $this->setInvalidInput('tirajeFacturaID');

            return false;
        }

        return true;
    }

    /**
     * La ID de la empresa debe ser un valor numérico entero positivo.
     * Valor opcional.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarEmpresa($input)
    {
        $v = new Optional($this->validadorPositivo);
        if ($v->validate($input['empresaID']) === false) {
            $this->setInvalidInput('empresaID');

            return false;
        }

        return true;
    }

    /**
     * La ID del cliente debe ser un valor numérico entero positivo.
     * Valor opcional.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarCliente($input)
    {
        $v = new Optional($this->validadorPositivo);
        if ($v->validate($input['clientePersonaID']) === false) {
            $this->setInvalidInput('clientePersonaID');

            return false;
        }

        return true;
    }
}