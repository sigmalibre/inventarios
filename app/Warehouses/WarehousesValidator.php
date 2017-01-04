<?php

namespace Sigmalibre\Warehouses;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\Length;
use Respect\Validation\Rules\StringType;
use Sigmalibre\Validation\Validator;

/**
 * Validador para inputs de las bodegas.
 */
class WarehousesValidator extends Validator
{
    /**
     * Realiza las validaciones específicas para crear y modificar los alamacenes de productos.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validate($input)
    {
        $this->validarNombre($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * El nombre del almacén debe ser un string de 1 a 50 carácteres de largo.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validarNombre(array $input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 50)
        );

        if ($v->validate($input['nombreAlmacen']) === false) {
            $this->setInvalidInput('nombreAlmacen');

            return false;
        }

        return true;
    }
}