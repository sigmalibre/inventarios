<?php

namespace Sigmalibre\Empresas;

use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewDireccion;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewEmail;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewTelefono;
use Sigmalibre\DatosGenerales\Direccion;
use Sigmalibre\DatosGenerales\Email;
use Sigmalibre\DatosGenerales\Telefono;
use Sigmalibre\DatosGenerales\ValidadorDireccion;
use Sigmalibre\DatosGenerales\ValidadorEmails;
use Sigmalibre\DatosGenerales\ValidadorTelefono;
use Sigmalibre\Empresas\DataSource\CountFilteredEmpresas;
use Sigmalibre\Empresas\DataSource\FilterEmpresas;
use Sigmalibre\Empresas\DataSource\SaveNewEmpresa;
use Sigmalibre\Empresas\DataSource\SearchAllEmpresas;
use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\Pagination\Paginator;

/**
 * Modelo para operaciones sobre empresas
 */
class Empresas
{
    private $container;
    private $validador;
    private $validadorDirecciones;
    private $validadorTelefonos;
    private $validadorEmails;

    public function __construct($container)
    {
        $this->container = $container;
        $this->validador = new ValidadorEmpresa();
        $this->validadorDirecciones = new ValidadorDireccion();
        $this->validadorTelefonos = new ValidadorTelefono();
        $this->validadorEmails = new ValidadorEmails();
    }

    /**
     * Obtiene una lista con todas las empresas encontradas por los filtros de búsqueda.
     *
     * @param $input
     *
     * @return array
     */
    public function getFiltered($input)
    {
        $reader = new ItemListReader(
            new CountFilteredEmpresas($this->container),
            new FilterEmpresas($this->container),
            new Paginator($input),
            $input
        );

        $itemList = $reader->read();
        $itemList['userInput'] = $input;

        return $itemList;
    }

    /**
     * Obtiene una lista con todas las empresas sin filtrar.
     *
     * @return array
     */
    public function getAll()
    {
        $reader = new SearchAllEmpresas($this->container);

        return $reader->read([]);
    }

    /**
     * Crea una nueva empresa y la guarda en la fuente de datos.
     *
     * @param $input
     *
     * @return bool
     */
    public function save($input)
    {
        $input = array_map('trim', $input);

        $isInputValid = $this->runValidators($input);
        if ($isInputValid === false) {
            return false;
        }

        $this->container->mysql->beginTransaction();

        $newEmpresaID = $this->saveEmpresa($input);
        if ($newEmpresaID === false) {
            $this->container->mysql->rollBack();

            return false;
        }

        $newDireccionID = (new Direccion())->save(new SaveNewDireccion($this->container), $input['direccion'], ['empresaID' => $newEmpresaID]);
        $newTelefonoID = (new Telefono())->save(new SaveNewTelefono($this->container), $input['telefono'], ['empresaID' => $newEmpresaID]);
        $newEmailID = (new Email())->save(new SaveNewEmail($this->container), $input['email'], ['empresaID' => $newEmpresaID]);

        if ($newDireccionID === false || $newTelefonoID === false || $newEmailID === false) {
            $this->container->mysql->rollBack();

            return false;
        }

        $this->container->mysql->commit();

        return true;
    }

    /**
     * Corre todos los validadores necesarios para comprobar los datos de una empresa.
     *
     * @param $input
     *
     * @return bool
     */
    public function runValidators($input)
    {
        $this->validador->validate($input);
        $this->validadorDirecciones->validate($input);
        $this->validadorTelefonos->validate($input);
        $this->validadorEmails->validate($input);

        return empty($this->getInvalidInputs());
    }

    /**
     * Obtiene todos los inputs que no aprovaron la validación.
     *
     * @return array
     */
    public function getInvalidInputs()
    {
        return array_merge(
            $this->validador->getInvalidInputs(),
            $this->validadorDirecciones->getInvalidInputs(),
            $this->validadorTelefonos->getInvalidInputs(),
            $this->validadorEmails->getInvalidInputs()
        );
    }

    /**
     * Guarda una nueva empresa en la fuente de datos.
     *
     * @param $input
     *
     * @return bool|string
     */
    private function saveEmpresa($input)
    {
        return (new SaveNewEmpresa($this->container))->write([
            'nombreComercial' => $input['nombreComercial'],
            'razonSocial' => $input['razonSocial'],
            'giro' => $input['giro'],
            'registro' => $input['registro'],
            'nit' => $input['nit'],
        ]);
    }
}