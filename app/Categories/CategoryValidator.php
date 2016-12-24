<?php

namespace Sigmalibre\Categories;

/**
 * Validación de los datos para las operaciones de categorías de producto.
 */
class CategoryValidator extends \Sigmalibre\Validation\Validator
{
    /**
     * Realiza validaciones específicas para crear una nueva categoria de producto.
     *
     * @param array $userInput Input del usuario a validar
     *
     * @return bool True si ha pasado las validaciones; False de lo contrario
     */
    public function validateNewCategory($userInput)
    {
        $validator = $this->container->validator;

        // El código de la categoría debe ser un string sin espacios de 2 dígitos de largo.
        if ($validator::stringType()->noWhitespace()->length(2, 2)->validate($userInput['codigoCategoria']) === false) {
            $this->invalidUserInputs['codigoCategoria'] = true;

            return false;
        }

        // El nombre de la categoría debe ser un string de 1 a 30 caracteres.
        if ($validator::stringType()->length(1, 50)->validate($userInput['nombreCategoria']) === false) {
            $this->invalidUserInputs['nombreCategoria'] = true;

            return false;
        }

        return true;
    }
}
