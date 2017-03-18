<?php

namespace Sigmalibre\Categories;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\Length;
use Respect\Validation\Rules\NoWhitespace;
use Respect\Validation\Rules\StringType;
use Sigmalibre\Validation\Validator;

/**
 * Validación de los datos para las operaciones de categorías de producto.
 */
class CategoryValidator extends Validator
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
        $v = new AllOf(
            new StringType(),
            new NoWhitespace(),
            new Length(2, 2)
        );

        if ($v->validate($input['codigoCategoria']) === false) {
            $this->setInvalidInput('codigoCategoria');

            return false;
        }

        return true;
    }

    /**
     * El nombre de la categoría debe ser un string de 1 a 50 carácteres.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validarNombre($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 25)
        );

        if ($v->validate($input['nombreCategoria']) === false) {
            $this->setInvalidInput('nombreCategoria');

            return false;
        }

        return true;
    }
}
