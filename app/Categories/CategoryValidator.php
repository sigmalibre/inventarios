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
     * @param array $input Input del usuario a validar
     *
     * @return bool True si ha pasado las validaciones; False de lo contrario
     */
    public function validate($input)
    {
        $this->validarCodigo($input);
        $this->validarNombre($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * El código de la categoría debe ser un string sin espacios de 2 dígitos de largo.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validarCodigo($input)
    {
        if ($this->v::stringType()->noWhitespace()->length(2, 2)->validate($input['codigoCategoria']) === false) {
            $this->setInvalidInput('codigoCategoria');

            return false;
        }

        return true;
    }

    /**
     * El nombre de la categoría debe ser un string de 1 a 50 caracteres.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validarNombre($input)
    {
        if ($this->v::stringType()->length(1, 50)->validate($input['nombreCategoria']) === false) {
            $this->setInvalidInput('nombreCategoria');

            return false;
        }

        return true;
    }
}
