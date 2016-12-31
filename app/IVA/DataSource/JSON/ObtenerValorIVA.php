<?php

namespace Sigmalibre\IVA\DataSource\JSON;

use Sigmalibre\DataSource\JSON\JSONFileReader;

/**
 * Obtiene el valor del iva desde el archivo iva.json
 */
class ObtenerValorIVA extends JSONFileReader
{
    /**
     * Obtiene el valor del porcentaje del IVA.
     *
     * @return array|bool
     */
    public function getIva()
    {
        return $this->read(APP_ROOT . '/app/config/iva.json');
    }
}