<?php

namespace Sigmalibre\Clients;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\Length;
use Respect\Validation\Rules\Optional;
use Respect\Validation\Rules\StringType;
use Sigmalibre\Validation\Validator;

class ValidadorCliente extends Validator
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
        $this->validarNombres($input);
        $this->validarApellidos($input);
        $this->validarDUI($input);
        $this->validarNIT($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * Los nombres deben ser un string de 1 a 255 carácteres.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarNombres($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 255, true)
        );

        if ($v->validate($input['nombres']) === false) {
            $this->setInvalidInput('nombres');

            return false;
        }

        return true;
    }

    /**
     * Los apellidos deben ser un string de 1 a 255 carácteres.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarApellidos($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 255, true)
        );

        if ($v->validate($input['apellidos']) === false) {
            $this->setInvalidInput('apellidos');

            return false;
        }

        return true;
    }

    /**
     * El DUI debe ser un string de 1 a 15 carácteres.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarDUI($input)
    {
        $v = new Optional(
            new AllOf(
                new StringType(),
                new Length(1, 15, true)
            )
        );

        if ($v->validate($input['dui']) === false) {
            $this->setInvalidInput('dui');

            return false;
        }

        return true;
    }

    /**
     * El NIT debe ser un string de 1 a 20 carácteres.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarNIT($input)
    {
        $v = new Optional(
            new AllOf(
                new StringType(),
                new Length(1, 20, true)
            )
        );

        if ($v->validate($input['nit']) === false) {
            $this->setInvalidInput('nit');

            return false;
        }

        return true;
    }
}