<?php
namespace Sigmalibre\DataSource;

/**
 * Interfaz que debe implementar una clase que quiera leer de una fuente de datos.
 */
interface ReadInterface
{
    /**
     * Leer de la fuente de datos, pide un parametro con identificadores para buscar un registro específico.
     * @param  string|array $identifiers Identificador/es para buscar un registro específico en una fuente de datos.
     * @return array Devuelve el registro si fue encontrado.
     */
    public function read($identifiers);
}
