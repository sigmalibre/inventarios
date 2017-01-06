<?php

namespace Sigmalibre\DatosGenerales;

use Sigmalibre\DataSource\WriteInterface;

/**
 * Modelo para operaciones sobre Direcciones.
 */
class Direccion
{
    /**
     * @param \Sigmalibre\DataSource\WriteInterface $writer
     * @param string                                $direccion
     * @param array                                 $owner
     *
     * @return mixed
     */
    public function save(WriteInterface $writer, string $direccion, array $owner)
    {
        return $writer->write([
            'direccion' => $direccion,
            'empresaID' => $owner['empresaID'] ?? null,
            'empleadoID' => $owner['empleadoID'] ?? null,
            'clientePersonaID' => $owner['clientePersonaID'] ?? null,
            'almacenID' => $owner['almacenID'] ?? null,
        ]);
    }
}