<?php

namespace Sigmalibre\Validation;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\IntVal;
use Respect\Validation\Rules\Positive;

class ValidadorDatosGenerales extends Validator
{
    private $intValidator;

    public function __construct()
    {
        $this->intValidator = new AllOf(
            new IntVal(),
            new Positive()
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
        $this->validarIDEmpresa($input);
        $this->validarIDEmpleado($input);
        $this->validarIDClientePersona($input);
        $this->validarIDAlmacen($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * El EmpresaID debe ser un número entero positivo. Valor opcional.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarIDEmpresa($input)
    {
        if ($this->intValidator->validate($input['empresaID']) === false) {
            $this->setInvalidInput('empresaID');

            return false;
        }

        return true;
    }

    /**
     * El EmpleadoID debe ser un número entero positivo. Valor opcional.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarIDEmpleado($input)
    {
        if ($this->intValidator->validate($input['empleadoID']) === false) {
            $this->setInvalidInput('empleadoID');

            return false;
        }

        return true;
    }

    /**
     * El ClientePersonaID debe ser un número entero positivo. Valor opcional.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarIDClientePersona($input)
    {
        if ($this->intValidator->validate($input['clientePersonaID']) === false) {
            $this->setInvalidInput('clientePersonaID');

            return false;
        }

        return true;
    }

    /**
     * El AlmacenID debe ser un número entero positivo. Valor opcional.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarIDAlmacen($input)
    {
        if ($this->intValidator->validate($input['almacenID']) === false) {
            $this->setInvalidInput('almacenID');

            return false;
        }

        return true;
    }
}