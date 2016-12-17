<?php

namespace Sigmalibre\DataSource\JSON;

/**
 * Guarda datos en formato JSON.
 */
class JSONFileWriter implements \Sigmalibre\DataSource\WriteInterface
{
    /**
     * Transforma una estructura a formato JSON y la guarda en un archivo.
     *
     * El directorio donde se guarde el archivo debe existir y debe tener permisos de escritura.
     *
     * @param string $path     Ruta del archivo a escribir
     * @param mixed  $contents Datos que se guardarán
     *
     * @return bool True si se pudo escribir; False de lo contrario
     */
    public function write($path, $contents)
    {
        $json = json_encode($contents, JSON_PRETTY_PRINT);

        if ($json === false) {
            return false;
        }

        $isWriten = file_put_contents($path, $json);

        if ($isWriten === false) {
            return false;
        }

        return true;
    }
}
