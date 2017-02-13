<?php

namespace Sigmalibre\DataSource\JSON;

/**
 * Almacena la configuración del sistema en un archivo JSON.
 */
class ConfigWriter extends JSONFileWriter
{
    protected $path = APP_ROOT . '/app/config/config.json';
    private $reader;

    public function __construct()
    {
        $this->reader = new JSONFileReader();
    }

    /**
     * Guarda el ajuste de usuario.
     *
     * @param $key
     * @param $value
     *
     * @return bool
     */
    public function save($key, $value)
    {
        $config = $this->reader->read($this->path);
        $config[$key] = $value;

        return $this->write($config);
    }
}
