<?php

namespace Sigmalibre\TirajeFactura\DataSource\JSON;

use Sigmalibre\DataSource\JSON\JSONFileReader;

/**
 * Realiza una lectura de la ID del tiraje actual para factura y para crédito fiscal.
 */
class TirajeActualReader extends JSONFileReader
{
    /**
     * Obtiene el valor de la ID que es el tiraje actual para facturas nuevas.
     *
     * @param $tipo
     *
     * @return mixed
     */
    public function getIDTiraje($tipo)
    {
        return $this->read(APP_ROOT . '/app/config/tirajeactual.json')[$tipo];
    }
}