<?php

namespace Sigmalibre\DatosGenerales;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\Email;
use Respect\Validation\Rules\Length;
use Respect\Validation\Rules\StringType;
use Sigmalibre\Validation\Validator;

/**
 * Realiza validaciones para datos de correo electrónico
 */
class ValidadorEmails extends Validator
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
        $this->validarEmail($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * El email debe ser válido al siguiente formato: correo@dominio.ext
     * Por ejemplo: jaiermarquezportillo@gmail.com y no debe sobrepasar los
     * 45 carácteres.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarEmail($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 45),
            new Email()
        );
        
        if ($v->validate($input['email']) === false) {
            $this->setInvalidInput('email');

            return false;
        }

        return true;
    }
}