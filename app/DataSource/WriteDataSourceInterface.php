<?php
namespace Sigmalibre\DataSource;

/**
 * Interfaz que debe implementar una clase que quiera escribir hacia uan fuente de datos.
 */
interface WriteDataSourceInterface
{
    /**
     * Crea nuevos registros dentro de la fuente de datos.
     * @param  array $newDataList Lista con los nuevos datos a ser insertados.
     * @return boolean True si la inserción fue exitosa, false de lo contrario.
     */
    public function write($newDataList);

    /**
     * Actualiza un registro de la fuente de datos.
     * @param  string|array $identifiers Identificador/es para buscar un registro específico en una fuente de datos, el cual será actualizado.
     * @param  array $newDataToUpdateList Lista con los nuevos datos a ser actualizados.
     * @return boolean True si la actualización fue exitosa, false de lo contrario.
     */
    public function update($identifiers, $newDataToUpdateList);

    /**
     * Elimina un registro de la fuente de datos.
     * @param  string|array $identifiers Identificador/es para buscar un registro específico en una fuente de datos, el cual será eliminado.
     * @return boolean True si la eliminación fue exitosa, false de lo contrario.
     */
    public function delete($identifiers);
}
