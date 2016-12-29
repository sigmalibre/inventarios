<?php

namespace Sigmalibre\UnitsOfMeasurement;

class UnitValidator extends \Sigmalibre\Validation\Validator
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
     * La unidad de medida del producto debe ser un string de 100 caracteres o menos.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validarNombre($input)
    {
        if ($this->v::stringType()->length(1, 100)->validate($input['unidadMedida']) === false) {
            $this->setInvalidInput('unidadMedida');

            return false;
        }

        return true;
    }
}
