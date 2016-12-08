<?php

namespace Sigmalibre\Validation;

/**
 * Clase abstracta para los validadores de inputs de usuario.
 */
abstract class Validator
{
    protected $container;
    protected $invalidUserInputs = [];

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
}
