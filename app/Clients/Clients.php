<?php

namespace Sigmalibre\Clients;

use Sigmalibre\Clients\DataSource\MySQL\SaveNewCliente;
use Sigmalibre\Clients\DataSource\MySQL\SearchAllClientes;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewDireccion;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewTelefono;
use Sigmalibre\DatosGenerales\Direccion;
use Sigmalibre\DatosGenerales\Telefono;
use Sigmalibre\DatosGenerales\ValidadorDireccion;
use Sigmalibre\DatosGenerales\ValidadorTelefono;
use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\Pagination\Paginator;

/**
 * Modelo para las operaciones CRUD sobre los clientes.
 */
class Clients
{
    private $container;
    private $validator;
    private $validadorDirecciones;
    private $validadorTelefonos;

    public function __construct($container)
    {
        $this->container = $container;
        $this->validator = new ValidadorCliente();
        $this->validadorDirecciones = new ValidadorDireccion();
        $this->validadorTelefonos = new ValidadorTelefono();
    }

    /**
     * Obtiene la lista con todas las personas clientes de la empresa
     * según los términos de búsqueda y la pagínación.
     *
     * @param array $userInput Input del usuario con los filtros para la búsqueda
     *
     * @return array Lista con los clientes encontrados
     */
    public function readPeopleList($userInput)
    {
        $listReader = new ItemListReader(
            new DataSource\MySQL\CountFilteredClientePersona($this->container),
            new DataSource\MySQL\FilterClientePersona($this->container),
            new Paginator($userInput),
            $userInput
        );

        $clientList = $listReader->read();
        $clientList['userInput'] = $userInput;

        return $clientList;
    }

    /**
     * Obtiene una lista con todos los clientes sin filtrar.
     *
     * @return array
     */
    public function getAllClients()
    {
        $clients = new SearchAllClientes($this->container);
        return $clients->read([]);
    }

    /**
     * Obtiene la lista con todas las empresas contribuyentes
     * según los términos de búsqueda y la pagínación.
     *
     * @param array $userInput Input del usuario con los filtros para la búsqueda
     *
     * @return array Lista con los clientes encontrados
     */
    public function readCompanyList($userInput)
    {
        $listReader = new ItemListReader(
            new DataSource\MySQL\CountFilteredClienteEmpresa($this->container),
            new DataSource\MySQL\FilterClienteEmpresa($this->container),
            new Paginator($userInput),
            $userInput
        );

        $clientList = $listReader->read();
        $clientList['userInput'] = $userInput;

        return $clientList;
    }

    /**
     * Guarda la información de un cliente en la fuente de datos.
     *
     * @param array $input
     *
     * @return bool
     */
    public function save(array $input)
    {
        $input = array_map('trim', $input);

        $isInputValid = $this->runValidators($input);
        if ($isInputValid === false) {
            return false;
        }

        $this->container->mysql->beginTransaction();

        $newClientID = $this->saveClient($input);
        if ($newClientID === false) {
            $this->container->mysql->rollBack();

            return false;
        }

        if (!empty($input['direccion'])) {
            $newDireccionID = (new Direccion())->save(new SaveNewDireccion($this->container), $input['direccion'], ['clientePersonaID' => $newClientID]);
        }
        if (!empty($input['telefono'])) {
            $newTelefonoID = (new Telefono())->save(new SaveNewTelefono($this->container), $input['telefono'], ['clientePersonaID' => $newClientID]);
        }

        $this->container->mysql->commit();

        return true;
    }

    private function runValidators($input)
    {
        $this->validator->validate($input);
        if (!empty($input['direccion'])) {
            $this->validadorDirecciones->validate($input);
        }
        if (!empty($input['telefono'])) {
            $this->validadorTelefonos->validate($input);
        }

        return empty($this->getInvalidInputs());
    }

    /**
     * Obtiene todos los inputs que no pasaron la validación al crear un cliente nuevo.
     *
     * @return array
     */
    public function getInvalidInputs()
    {
        return array_merge(
            $this->validator->getInvalidInputs(),
            $this->validadorDirecciones->getInvalidInputs(),
            $this->validadorTelefonos->getInvalidInputs()
        );
    }

    private function saveClient($input)
    {
        $writer = new SaveNewCliente($this->container);

        return $writer->write([
            'nombres' => $input['nombres'],
            'apellidos' => $input['apellidos'],
            'dui' => $input['dui'],
            'nit' => $input['nit'],
        ]);
    }
}
