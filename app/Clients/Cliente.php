<?php

namespace Sigmalibre\Clients;

use Sigmalibre\Clients\DataSource\MySQL\GetClienteFromID;
use Sigmalibre\Clients\DataSource\MySQL\UpdateCliente;
use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewDireccion;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewTelefono;
use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateDireccionCliente;
use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateTelefonoCliente;
use Sigmalibre\DatosGenerales\Direccion;
use Sigmalibre\DatosGenerales\Telefono;
use Sigmalibre\DatosGenerales\ValidadorDireccion;
use Sigmalibre\DatosGenerales\ValidadorTelefono;

/**
 * Modelo para operaciones con un cliente.
 */
class Cliente
{
    private $container;
    private $validator;
    private $validadorDirecciones;
    private $validadorTelefonos;
    private $attributes;
    /** @var MySQLTransactions $transaction */
    private $transaction;

    private $id;
    private $nombres;
    private $apellidos;
    private $dui;
    private $nit;
    private $direccion;
    private $telefono;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @return string
     */
    public function getDui()
    {
        return $this->dui;
    }

    /**
     * @return string
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Inicializa el objeto obteniendo sus datos desde la fuente de datos.
     *
     * @param $id
     */
    public function init($id)
    {
        $this->attributes = [];
        $dataSource = new GetClienteFromID($this->container);
        $this->attributes = $dataSource->read([
            'input' => [
                'idClientePersona' => $id,
            ],
        ]);

        $this->id = $id;
        $this->nombres = $this->attributes[0]['Nombres'];
        $this->apellidos = $this->attributes[0]['Apellidos'];
        $this->dui = $this->attributes[0]['DUI'];
        $this->nit = $this->attributes[0]['NIT'];
        $this->direccion = $this->attributes[0]['Direccion'];
        $this->telefono = $this->attributes[0]['Telefono'];
    }

    public function __construct($id, $container)
    {
        $this->container = $container;
        $this->transaction = $container->mysql;
        $this->validator = new ValidadorCliente();
        $this->validadorDirecciones = new ValidadorDireccion();
        $this->validadorTelefonos = new ValidadorTelefono();

        $this->init($id);
    }

    /**
     * Comprueba si el objeto existe en la fuente de datos;
     *
     * @return bool
     */
    public function is_set()
    {
        return isset($this->attributes[0]);
    }

    /**
     * Actualiza la información sobre un cliente en la fuente de datos.
     *
     * @param array $input
     *
     * @return bool
     */
    public function update(array $input)
    {
        // Limpiar los espacios en blanco al inicio y final de todos los inputs.
        $input = array_map('trim', $input);

        // Validar el input del usuario.
        $isInputValid = $this->runValidators($input);
        if ($isInputValid === false) {
            return false;
        }

        $this->transaction->beginTransaction();

        $isClienteUpdated = $this->updateCliente($input);
        if ($isClienteUpdated === false) {
            $this->transaction->rollBack();

            return false;
        }

        $isDirectionUpdated = $this->updateDireccion($input['direccion']);
        $isTelefonoUpdated = $this->updateTelefono($input['telefono']);

        if ($isDirectionUpdated === false || $isTelefonoUpdated === false) {
            $this->transaction->rollBack();

            return false;
        }

        $this->transaction->commit();

        $this->init($this->id);

        return true;
    }

    private function runValidators($input)
    {
        $this->validator->validate($input);
        $this->validadorDirecciones->validate($input);
        $this->validadorTelefonos->validate($input);

        return empty($this->getInvalidInputs());
    }

    /**
     * Obtiene los inputs que no pasaron la validación.
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

    private function updateCliente($input)
    {
        $writer = new UpdateCliente($this->container);

        return $writer->write([
            'nombres' => $input['nombres'],
            'apellidos' => $input['apellidos'],
            'dui' => $input['dui'],
            'nit' => $input['nit'],
            'id' => $this->id,
        ]);
    }

    /**
     * Actualiza una dirección de un cliente, o la crea si no existe.
     *
     * @param string $direccion
     *
     * @return bool
     */
    private function updateDireccion($direccion)
    {
        if (isset($this->direccion) === false) {
            $is_saved = (new Direccion())->save(new SaveNewDireccion($this->container), $direccion, ['clientePersonaID' => $this->id]);

            if ($is_saved === false) {
                return false;
            }

            $this->direccion = $direccion;

            return true;
        }

        $is_updated = (new Direccion())->save(new UpdateDireccionCliente($this->container), $direccion, ['clientePersonaID' => $this->id]);

        if ($is_updated === false) {
            return false;
        }

        $this->direccion = $direccion;

        return true;
    }

    /**
     * Actualiza un teléfono de un cliente, o lo crea si no existe.
     *
     * @param string $telefono
     *
     * @return bool
     */
    private function updateTelefono($telefono)
    {
        if (isset($this->telefono) === false) {
            $is_saved = (new Telefono())->save(new SaveNewTelefono($this->container), $telefono, ['clientePersonaID' => $this->id]);

            if ($is_saved === false) {
                return false;
            }

            $this->telefono = $telefono;

            return true;
        }

        $is_updated = (new Telefono())->save(new UpdateTelefonoCliente($this->container), $telefono, ['clientePersonaID' => $this->id]);

        if ($is_updated === false) {
            return false;
        }

        $this->telefono = $telefono;

        return true;
    }
}