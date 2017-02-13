<?php

namespace Sigmalibre\DataSource\JSON;

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
    public function read($tipo)
    {
        return parent::read(APP_ROOT . '/app/config/config.json')[$tipo] ?? false;
    }
}