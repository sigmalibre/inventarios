<?php

namespace Sigmalibre\Brands;

class BrandValidator extends \Sigmalibre\Validation\Validator
{
    /**
     * Realiza validaciones específicas para crear y modificar una marca de producto.
     *
     * @param array $userInput Input del usuario a validar
     *
     * @return bool True si ha aprovado las validaciones; False de lo contrario
     */
    public function validateBrand($userInput)
    {
        $validator = $this->container->validator;

        // La marca del producto debe ser un string de 100 caracteres o menos
        if ($validator::stringType()->length(1, 100)->validate($userInput['nombreMarca']) === false) {
            return false;
        }
    }
}
