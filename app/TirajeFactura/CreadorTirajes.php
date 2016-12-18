<?php

namespace Sigmalibre\TirajeFactura;

/**
 * Crea tirajes nuevos.
 */
class CreadorTirajes
{
    private $container;
    private $validator;

    public function __construct($container)
    {
        $this->container = $container;
        $this->validator = new TirajeValidator($container);
    }

    /**
     * Guarda un tiraje nuevo en la fuente de datos,
     * utlizando el input del usuario.
     *
     * @param array $userInput Los datos desde el input para crear el nuevo tiraje
     *
     * @return bool True si se pudo crear; False de lo contrario
     */
    public function save($userInput)
    {
        // Validar el input del usuario.
        if ($this->validator->validate($userInput) === false) {
            return false;
        }

        $writer = new DataSource\MySQL\GuardarNuevoTiraje($this->container);

        return $writer->write($userInput);
    }

    /**
     * Obtiene la lista con los inputs inválidos al crear la marca.
     * Se utiliza para dar mejor feedback al usuario.
     *
     * @return array Lista con todos los inputs que no pasaron la validación
     */
    public function getInvalidInputs()
    {
        return $this->validator->getInvalidInputs();
    }
}
