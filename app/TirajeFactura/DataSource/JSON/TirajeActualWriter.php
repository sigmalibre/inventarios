<?php

namespace Sigmalibre\TirajeFactura\DataSource\JSON;

use Sigmalibre\DataSource\JSON\JSONFileWriter;

/**
 * Almacena en un archivo JSON la ID para el tiraje actual de facturas nuevas.
 */
class TirajeActualWriter extends JSONFileWriter
{
    protected $path = APP_ROOT . '/app/config/tirajeactual.json';

    /**
     * Guarda la id para el tiraje actual para nuevas facturas.
     *
     * @param $tipo
     * @param $id
     *
     * @return bool
     */
    public function save($tipo, $id)
    {
        $tirajesActuales = (new TirajeActualReader())->getIDTiraje($tipo);
        $tirajesActuales[$tipo] = $id;

        return $this->write($tirajesActuales);
    }
}