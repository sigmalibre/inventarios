<?php

namespace Sigmalibre\Categories;

/**
 * Validación de los datos para las operaciones de categorías de producto.
 */
class CategoryValidator
{
    private $container;
    private $invalidUserInputs = [];

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Si uno de los métodos de guardado de datos retorna falso, y es culpa de un input
     * que no pasó la validación, se puede usar esta función para obtener una lista con
     * los inputs que no pasaron la prueba, por ejemplo para darle feedback al usuario.
     *
     * @return array La lista de los inputs inválidos
     */
    public function getInvalidInputs()
    {
        return $this->invalidUserInputs;
    }

    /**
     * Ajustar manualmente un input como inválido.
     *
     * Nesesario en situaciones donde se hace validación extra afuera de esta clase.
     *
     * @param string $inputName Nombre del input
     */
    public function setInvalidInput($inputName)
    {
        $this->invalidUserInputs[$inputName] = true;
    }

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
        if ($validator::stringType()->length(1, 30)->validate($userInput['nombreCategoria']) === false) {
            $this->invalidUserInputs['nombreCategoria'] = true;

            return false;
        }

        return true;
    }
}
