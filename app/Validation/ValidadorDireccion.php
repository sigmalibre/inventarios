<?php

namespace Sigmalibre\Validation;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\IntVal;
use Respect\Validation\Rules\Length;
use Respect\Validation\Rules\Optional;
use Respect\Validation\Rules\Positive;
use Respect\Validation\Rules\StringType;

class ValidadorDireccion extends Validator
{
    private $len45validator;
    private $optionalIntValidator;

    public function __construct()
    {
        $this->len45validator = new AllOf(
            new StringType(),
            new Length(1, 45, true)
        );

        $this->optionalIntValidator = new Optional(
            new AllOf(
                new IntVal(),
                new Positive()
            )
        );
    }

    /**
     * Realiza validaciones específicas para los campos de una dirección.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validate($input)
    {
        $this->validarPais($input);
        $this->validarDepartamento($input);
        $this->validarMunicipio($input);
        $this->validarDireccion($input);
        $this->validarIDEmpresa($input);
        $this->validarIDEmpleado($input);
        $this->validarIDClientePersona($input);
        $this->validarIDAlmacen($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * País debe ser un string de 1 a 150 carácteres.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarPais($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 150, true)
        );

        if ($v->validate($input['pais']) === false) {
            $this->setInvalidInput('pais');

            return false;
        }

        return true;
    }

    /**
     * El departamento debe ser un string de 1 a 45 carácteres de largo.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarDepartamento($input)
    {
        if ($this->len45validator->validate($input['departamento']) === false) {
            $this->setInvalidInput('departamento');

            return false;
        }

        return true;
    }

    /**
     * El municipio debe ser uns string de 1 a 45 carácteres de largo.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarMunicipio($input)
    {
        if ($this->len45validator->validate($input['municipio']) === false) {
            $this->setInvalidInput('municipio');

            return false;
        }

        return true;
    }

    /**
     * La dirección debe ser uns string de 1 a 45 carácteres de largo.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarDireccion($input)
    {
        if ($this->len45validator->validate($input['direccion']) === false) {
            $this->setInvalidInput('direccion');

            return false;
        }

        return true;
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
        if ($this->optionalIntValidator->validate($input['empresaID']) === false) {
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
        if ($this->optionalIntValidator->validate($input['empleadoID']) === false) {
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
        if ($this->optionalIntValidator->validate($input['clientePersonaID']) === false) {
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
        if ($this->optionalIntValidator->validate($input['almacenID']) === false) {
            $this->setInvalidInput('almacenID');

            return false;
        }

        return true;
    }
}