<?php

namespace Sigmalibre\Validation;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\Length;
use Respect\Validation\Rules\StringType;

class ValidadorDireccion extends ValidadorDatosGenerales
{
    /**
     * Realiza validaciones específicas para los campos de una dirección.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validate($input)
    {
        $this->validarDireccion($input);
        $this->validarIDEmpresa($input);
        $this->validarIDEmpleado($input);
        $this->validarIDClientePersona($input);
        $this->validarIDAlmacen($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * La dirección debe ser uns string de 1 a 255 carácteres de largo.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarDireccion($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 255, true)
        );

        if ($v->validate($input['direccion']) === false) {
            $this->setInvalidInput('direccion');

            return false;
        }

        return true;
    }
}