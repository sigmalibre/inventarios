<?php

namespace Sigmalibre\Brands;

class BrandValidator extends \Sigmalibre\Validation\Validator
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
        if ($this->v::stringType()->length(1, 100)->validate($input['nombreMarca']) === false) {
            $this->setInvalidInput('nombreMarca');

            return false;
        }

        return true;
    }
}
