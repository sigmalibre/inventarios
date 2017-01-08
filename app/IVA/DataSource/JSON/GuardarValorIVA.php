<?php

namespace Sigmalibre\IVA\DataSource\JSON;

use Sigmalibre\DataSource\JSON\JSONFileWriter;

/**
 * Guarda el porcentaje del IVA en un archivo de configuración.
 */
class GuardarValorIVA extends JSONFileWriter
{
    protected $path = APP_ROOT . '/app/config/iva.json';

    /**
     * Guarda el porcentaje del IVA en app/config/iva.json
     *
     * Advertencia: los datos ya deberán llegar validados en este punto.
     *
     * @param float $porcentajeIVA
     *
     * @return bool
     */
    public function save(float $porcentajeIVA)
    {
        return $this->write($porcentajeIVA);
    }
}