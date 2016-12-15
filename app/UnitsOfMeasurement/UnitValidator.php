<?php

namespace Sigmalibre\UnitsOfMeasurement;

class UnitValidator extends \Sigmalibre\Validation\Validator
{
    /**
     * Realiza validaciones específicas para crear y modificar una unidad de medida.
     *
     * @param array $userInput Input del usuario a validar
     *
     * @return bool True si ha aprovado las validaciones; False de lo contrario
     */
    public function validate($userInput)
    {
        $validator = $this->container->validator;

        // La unidad de medida del producto debe ser un string de 100 caracteres o menos
        if ($validator::stringType()->length(1, 100)->validate($userInput['unidadMedida']) === false) {
            return false;
        }
    }
}
