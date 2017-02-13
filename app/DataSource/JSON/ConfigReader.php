<?php

namespace Sigmalibre\DataSource\JSON;

/**
 * Realiza una lectura de la configuración del sistema.
 */
class ConfigReader extends JSONFileReader
{
    /**
     * Obtiene el valor del ajuste del sistema que se desea obtener.
     *
     * @param $key
     *
     * @return mixed
     */
    public function read($key)
    {
        return parent::read(APP_ROOT . '/app/config/config.json')[$key] ?? false;
    }
}