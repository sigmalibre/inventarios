<?php

namespace Sigmalibre\TirajeFactura;

/**
 * Calcula el siguiente correlativo para cada tiraje
 */
class SiguienteCorrelativo
{
    private $tiraje;

    /**
     * @param \Sigmalibre\TirajeFactura\TirajeFactura $tiraje
     */
    public function __construct(TirajeFactura $tiraje)
    {
        $this->tiraje = $tiraje;
    }

    /**
     * Obtiene el siguiente correlativo disponible para un tiraje de facturas.
     *
     * @return bool|int
     */
    public function getNext()
    {
        $correlativoSiguiente = (int)$this->tiraje->MaxCorrelativo + 1;

        if ($correlativoSiguiente > (int)$this->tiraje->TirajeHasta) {
            return false;
        }

        return $correlativoSiguiente;
    }
}