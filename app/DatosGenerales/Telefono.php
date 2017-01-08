<?php

namespace Sigmalibre\DatosGenerales;

use Sigmalibre\DataSource\WriteInterface;

/**
 * Modelo para operaciones sobre teléfonos
 */
class Telefono
{
    /**
     * @param \Sigmalibre\DataSource\WriteInterface $writer
     * @param string                                $telefono
     * @param array                                 $owner
     *
     * @return mixed
     */
    public function save(WriteInterface $writer, string $telefono, array $owner)
    {
        return $writer->write([
            'telefono' => $telefono,
            'empresaID' => $owner['empresaID'] ?? null,
            'empleadoID' => $owner['empleadoID'] ?? null,
            'clientePersonaID' => $owner['clientePersonaID'] ?? null,
            'almacenID' => $owner['almacenID'] ?? null,
        ]);
    }
}