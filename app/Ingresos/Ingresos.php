<?php

namespace Sigmalibre\Ingresos;

use Slim\Container;

/**
 * Modelo para operaciones sobre ingreso de productos.
 */
class Ingresos
{
    private $container;
    private $validator;

    /**
     * Ingresos constructor.
     *
     * @param $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->validator = new IngresosValidator($container);
    }

    /**
     * Guarda un ingreso de producto nuevo en la fuente de datos.
     *
     * @param array $userInput
     *
     * @return bool
     */
    public function save($userInput)
    {
        // Limpiar los espacios en blanco al inicio y final de todos los inputs.
        $userInput = array_map('trim', $userInput);

        // Ya que el campo de EmpresaID en la fuente de datos solo acepta INT y NULL, si se pasa un
        // string vacío, se convierte a NULL en su lugar.
        $userInput['empresaID'] = empty($userInput['empresaID']) ? null : $userInput['empresaID'];

        // Validar el input del usuario.
        if ($this->validator->validate($userInput) === false) {
            return false;
        }

        $writer = new DataSource\MySQL\SaveNewIngreso($this->container);

        return $writer->write($userInput);
    }

    /**
     * Obtiene los inputs que no pasaron la validación.
     *
     * @return array
     */
    public function getInvalidInputs()
    {
        return $this->validator->getInvalidInputs();
    }
}