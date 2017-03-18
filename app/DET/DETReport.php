<?php

namespace Sigmalibre\DET;

use Sigmalibre\Products\Products;

/**
 * Crea un archivo de texto con la información del sistema para generar un reporte
 * compatible con el sistema DET.
 *
 * Información  para el formulario F983 v2 del Ministerio de Hacienda
 */
class DETReport
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    private function mb_str_pad($str, $pad_len, $pad_str = ' ', $dir = STR_PAD_RIGHT, $encoding = null)
    {
        $encoding = $encoding === null ? mb_internal_encoding() : $encoding;
        $padBefore = $dir === STR_PAD_BOTH || $dir === STR_PAD_LEFT;
        $padAfter = $dir === STR_PAD_BOTH || $dir === STR_PAD_RIGHT;
        $pad_len -= mb_strlen($str, $encoding);
        $targetLen = $padBefore && $padAfter ? $pad_len / 2 : $pad_len;
        $strToRepeatLen = mb_strlen($pad_str, $encoding);
        $repeatTimes = ceil($targetLen / $strToRepeatLen);
        $repeatedString = str_repeat($pad_str, max(0, $repeatTimes)); // safe if used with valid utf-8 strings
        $before = $padBefore ? mb_substr($repeatedString, 0, floor($targetLen), $encoding) : '';
        $after = $padAfter ? mb_substr($repeatedString, 0, ceil($targetLen), $encoding) : '';

        return $before . $str . $after;
    }

    public function run()
    {
        // Obtener la lista de todos los productos

        $listaProductos = (new Products($this->container))->readAllProudcts();

        $reporte = '';

        foreach ($listaProductos as $p) {
            $linea = '';

            $linea .= $this->mb_str_pad($p['NombreCategoria'] . ' ' . $p['Descripcion'], 50, ' ', STR_PAD_RIGHT);
            $linea .= $this->mb_str_pad($p['UnidadMedida'], 24, ' ', STR_PAD_RIGHT);
            $linea .= str_pad($p['Cantidad'] * 10000000000, 22, ' ', STR_PAD_LEFT);
            $linea .= str_pad($p['CostoActual'] * 10000000000, 24, ' ', STR_PAD_LEFT);
            $linea .= str_pad($p['Cantidad'] * $p['CostoActual'] * 10000000000, 24, ' ', STR_PAD_LEFT);
            $linea .= ' ';
            $linea .= $p['CodigoBienDet'];
            $linea .= $p['CodigoLibroDet'];
            $linea .= (new \DateTime('now', new \DateTimeZone('America/El_Salvador')))->format('Y');
            $linea .= PHP_EOL;

            $reporte .= strtoupper($linea);
        }

        return $reporte;
    }
}
