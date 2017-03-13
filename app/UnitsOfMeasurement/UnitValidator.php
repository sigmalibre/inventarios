<?php

namespace Sigmalibre\UnitsOfMeasurement;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\Length;
use Respect\Validation\Rules\StringType;
use Sigmalibre\Validation\Validator;

class UnitValidator extends Validator
{
    /**
     * Realiza validaciones específicas para crear y modificar una unidad de medida.
     *
     * @param array $input Input del usuario a validar
     *
     * @return bool True si ha aprovado las validaciones; False de lo contrario
     */
    public function validate($input)
    {
        $this->validarNombre($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * La unidad de medida del producto debe ser un string de 100 carácteres o menos.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validarNombre($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 23)
        );

        if ($v->validate($input['unidadMedida']) === false) {
            $this->setInvalidInput('unidadMedida');

            return false;
        }

        return true;
    }
}
