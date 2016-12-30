<?php

namespace Sigmalibre\Brands;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\Length;
use Respect\Validation\Rules\StringType;
use Sigmalibre\Validation\Validator;

class BrandValidator extends Validator
{
    /**
     * Realiza validaciones específicas para crear y modificar una marca de producto.
     *
     * @param array $input Input del usuario a validar
     *
     * @return bool True si ha aprobado las validaciones; False de lo contrario
     */
    public function validate($input)
    {
        $this->validateNombre($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * La marca del producto debe ser un string de 100 carácteres o menos.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validateNombre($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 100)
        );

        if ($v->validate($input['nombreMarca']) === false) {
            $this->setInvalidInput('nombreMarca');

            return false;
        }

        return true;
    }
}
