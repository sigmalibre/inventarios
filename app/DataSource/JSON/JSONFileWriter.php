<?php

namespace Sigmalibre\DataSource\JSON;

use Sigmalibre\DataSource\WriteInterface;

/**
 * Guarda datos en formato JSON.
 */
class JSONFileWriter implements WriteInterface
{
    protected $path;

    /**
     * Transforma una estructura a formato JSON y la guarda en un archivo.
     *
     * El directorio donde se guarde el archivo debe existir y debe tener permisos de escritura.
     *
     * @param mixed $contents Datos que se guardarán
     *
     * @return bool True si se pudo escribir; False de lo contrario
     */
    public function write($contents)
    {
        $json = json_encode($contents, JSON_PRETTY_PRINT);

        if ($json === false) {
            return false;
        }

        $isWriten = file_put_contents($this->path, $json);

        if ($isWriten === false) {
            return false;
        }

        return true;
    }
}
