<?php

namespace Sigmalibre\DatosGenerales;
use Sigmalibre\DataSource\WriteInterface;

/**
 * Modelo para operaciones sobre correos electrónicos.
 */
class Email
{
    public function save(WriteInterface $writer, string $email, array $owner)
    {
        return $writer->write([
            'email' => $email,
            'empresaID' => $owner['empresaID'] ?? null,
            'empleadoID' => $owner['empleadoID'] ?? null,
        ]);
    }
}