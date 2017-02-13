<?php

namespace Sigmalibre\DataSource\JSON;

/**
 * Realiza una lectura de la configuración del sistema.
 */
class ConfigReader
{
    private $reader;

    public function __construct()
    {
        $this->reader = new JSONFileReader();
    }


    /**
     * Obtiene el valor del ajuste del sistema que se desea obtener.
     *
     * @param $key
     *
     * @return mixed
     */
    public function read($key)
    {
        return $this->reader->read(APP_ROOT . '/app/config/config.json')[$key] ?? false;
    }
}