<?php

namespace Sigmalibre\DatosGenerales;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\Length;
use Respect\Validation\Rules\StringType;
use Sigmalibre\Validation\Validator;

class ValidadorTelefono extends Validator
{
    /**
     * Realiza validaciones específicas para los campos de un teléfono.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validate($input)
    {
        $this->validarTelefono($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * Se realiza una validación liviana de los números de teléfono, debe ser entre 1 y 30 carácteres sin ningún formato
     * en especial.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarTelefono($input): bool
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 30, true)
        );

        if ($v->validate($input['telefono']) === false) {
            $this->setInvalidInput('telefono');

            return false;
        }

        return true;
    }


}