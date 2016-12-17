<?php

namespace Sigmalibre\DataSource;

/**
 * Interfaz que debe implementar una clase que quiera escribir hacia una fuente de datos.
 */
interface WriteInterface
{
    public function write();
}
