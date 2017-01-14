<?php

namespace Sigmalibre\DataSource\JSON;

/**
 * Realiza una lectura de un archivo en formato JSON.
 */
class JSONFileReader implements \Sigmalibre\DataSource\ReadInterface
{
    /**
     * Obtiene un array desde un archivo con formato JSON.
     *
     * @param string $path Ruta del archivo
     *
     * @return array|bool El array convertido desde JSON; False si ocurrió un error
     */
    public function read($path)
    {
        $fileContents = file_get_contents($path);

        if ($fileContents === false) {
            return false;
        }

        return json_decode(utf8_encode($fileContents), true);
    }
}
