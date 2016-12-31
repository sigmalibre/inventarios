<?php

namespace Sigmalibre\IVA;

use Sigmalibre\IVA\DataSource\JSON\GuardarValorIVA;
use Sigmalibre\IVA\DataSource\JSON\ObtenerValorIVA;

/**
 * Modelo para operaciones sobre el IVA.
 */
class IVA
{
    private $reader;
    private $writer;
    private $validator;

    public function __construct()
    {
        $this->reader = new ObtenerValorIVA();
        $this->writer = new GuardarValorIVA();
        $this->validator = new IVAValidator();
    }

    /**
     * Obtiene el porcentaje del IVA desde la fuente de datos.
     *
     * @return float|bool
     */
    public function getPorcentajeIVA()
    {
        return $this->reader->getIva();
    }

    /**
     * Guarda el valor del IVA en la fuente de datos.
     *
     * @param array $input
     *
     * @return bool
     */
    public function setPorcentajeIVA($input)
    {
        // Validar el input del usuario.
        if ($this->validator->validate($input) === false) {
            return false;
        }

        return $this->writer->save($input['porcentajeIVA']);
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