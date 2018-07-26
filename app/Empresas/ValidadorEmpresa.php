<?php

namespace Sigmalibre\Empresas;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\Length;
use Respect\Validation\Rules\StringType;
use Respect\Validation\Rules\Optional;
use Sigmalibre\Validation\Validator;

/**
 * Validador para datos de una empresa.
 */
class ValidadorEmpresa extends Validator
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
        $this->validarNombre($input);
        $this->validarRazonSocial($input);
        $this->validarGiro($input);
        $this->validarRegistro($input);
        $this->validarNit($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * El nombre comercial de la empresa debe ser un string de 1 a 100 carácteres.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarNombre($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 100)
        );

        if ($v->validate($input['nombreComercial']) === false) {
            $this->setInvalidInput('nombreComercial');

            return false;
        }

        return true;
    }

    /**
     * La razón social de la empresa debe ser un string de 1 a 50 carácteres.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarRazonSocial($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 50)
        );

        if ($v->validate($input['razonSocial']) === false) {
            $this->setInvalidInput('razonSocial');

            return false;
        }

        return true;
    }

    /**
     * El giro de la empresa debe ser un string de 1 a 255 carácteres.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarGiro($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 255)
        );

        if ($v->validate($input['giro']) === false) {
            $this->setInvalidInput('giro');

            return false;
        }

        return false;
    }

    /**
     * El número de registro comercial debe ser un string de 1 a 30 carácteres.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarRegistro($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 30, true)
        );

        if ($v->validate($input['registro']) === false) {
            $this->setInvalidInput('registro');

            return false;
        }

        return true;
    }

    /**
     * El NIT debe ser un string de 1 a 20 carácteres.
     * Por ahora solo se valida la longitud del string, sin revisar el formato
     * del NIT.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarNit($input)
    {
        $v = new Optional(
            new AllOf(
                new StringType(),
                new Length(1, 20)
            )
        );

        if ($v->validate($input['nit']) === false) {
            $this->setInvalidInput('nit');

            return false;
        }

        return true;
    }
}