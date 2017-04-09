<?php

namespace Sigmalibre\Empresas;

use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewDireccion;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewEmail;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewTelefono;
use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateDireccionEmpresa;
use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateEmailEmpresa;
use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateTelefonoEmpresa;
use Sigmalibre\DatosGenerales\Direccion;
use Sigmalibre\DatosGenerales\Email;
use Sigmalibre\DatosGenerales\Telefono;
use Sigmalibre\DatosGenerales\ValidadorDireccion;
use Sigmalibre\DatosGenerales\ValidadorEmails;
use Sigmalibre\DatosGenerales\ValidadorTelefono;
use Sigmalibre\Empresas\DataSource\DeleteEmpresa;
use Sigmalibre\Empresas\DataSource\GetEmpresaFromID;
use Sigmalibre\Empresas\DataSource\UpdateEmpresa;

class Empresa
{
    private $container;
    private $validador;
    private $validadorDirecciones;
    private $validadorTelefonos;
    private $validadorEmails;

    private $id;
    private $nombre;
    private $razonSocial;
    private $giro;
    private $registro;
    private $nit;
    private $direccion;
    private $telefono;
    private $email;

    /***********
     * GETTERS *
     ***********/

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    public function getGiro()
    {
        return $this->giro;
    }

    public function getRegistro()
    {
        return $this->registro;
    }

    public function getNit()
    {
        return $this->nit;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Inicializa los datos de la empresa.
     *
     * @param int $id La id de la empresa en la fuente de datos.
     * @param $container
     */
    public function __construct($id, $container)
    {
        $this->container = $container;
        $this->validador = new ValidadorEmpresa();
        $this->validadorDirecciones = new ValidadorDireccion();
        $this->validadorTelefonos = new ValidadorTelefono();
        $this->validadorEmails = new ValidadorEmails();

        $this->init($id);
    }

    /**
     * Obtiene la información dobre esta empresa desde la fuente de datos
     * y declara los atributos de este objeto utilizando dichos datos.
     *
     * @param $id
     *
     * @return bool
     */
    public function init($id)
    {
        $dataSource = new GetEmpresaFromID($this->container);
        $attributes = $dataSource->read([
            'input' => [
                'idEmpresa' => empty($id) ? -1 : $id,
            ],
        ]);

        if ($attributes === false) {
            return false;
        }

        $this->id = $attributes[0]['EmpresaID'] ?? null;
        $this->nombre = $attributes[0]['NombreComercial'] ?? null;
        $this->razonSocial = $attributes[0]['RazonSocial'] ?? null;
        $this->giro = $attributes[0]['Giro'] ?? null;
        $this->registro = $attributes[0]['Registro'] ?? null;
        $this->nit = $attributes[0]['NIT'] ?? null;
        $this->direccion = $attributes[0]['Direccion'] ?? null;
        $this->telefono = $attributes[0]['Telefono'] ?? null;
        $this->email = $attributes[0]['Email'] ?? null;

        return $this->is_set();
    }

    /**
     * Comprueba si se ha inicializado correctamente esta empresa.
     *
     * @return bool
     */
    public function is_set()
    {
        // Garantizar que al menos se obtiene el nomnbre.
        return isset($this->nombre);
    }

    /**
     * Actualiza los datos sobre esta empresa en la fuente de datos.
     *
     * @param $input
     *
     * @return bool
     */
    public function update($input)
    {
        $input = array_map('trim', $input);

        $isInputInvalid = $this->runValidators($input);
        if ($isInputInvalid === false) {
            return false;
        }

        $this->container->mysql->beginTransaction();

        $isEmpresaUpdated = $this->updateEmpresa($input);

        if ($isEmpresaUpdated === false) {
            $this->container->mysql->rollBack();

            return false;
        }

        $isDireccionUpdated = $this->updateDireccion($input['direccion']);
        $isTelefonoUpdated = $this->updateTelefono($input['telefono']);
        $isEmailUpdated = $this->updateEmail($input['email']);

        if ($isDireccionUpdated === false || $isTelefonoUpdated === false || $isEmailUpdated === false) {
            $this->container->mysql->rollBack();

            return false;
        }

        $this->container->mysql->commit();

        $this->init($this->id);

        return true;
    }

    /**
     * Se corren todos los validadores necesarios para verificar los datos de esta empresa.
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
     * Obtiene todos los inputs que no pasaron la prueba de los validadores.
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

    private function updateEmpresa($input)
    {
        return (new UpdateEmpresa($this->container))->write([
            'nombreComercial' => $input['nombreComercial'],
            'razonSocial' => $input['razonSocial'],
            'giro' => $input['giro'],
            'registro' => $input['registro'],
            'nit' => $input['nit'],
            'id' => $this->id,
        ]);
    }

    private function updateDireccion($direccion)
    {
        if (isset($this->direccion) === false) {
            $is_saved = (new Direccion())->save(new SaveNewDireccion($this->container), $direccion, ['empresaID' => $this->id]);

            if ($is_saved === false) {
                return false;
            }

            $this->direccion = $direccion;

            return true;
        }

        $is_updated = (new Direccion())->save(new UpdateDireccionEmpresa($this->container), $direccion, ['empresaID' => $this->id]);

        if ($is_updated === false) {
            return false;
        }

        $this->direccion = $direccion;

        return true;
    }

    private function updateTelefono($telefono)
    {
        if (isset($this->telefono) === false) {
            $is_saved = (new Telefono())->save(new SaveNewTelefono($this->container), $telefono, ['empresaID' => $this->id]);

            if ($is_saved === false) {
                return false;
            }

            $this->telefono = $telefono;

            return true;
        }

        $is_updated = (new Telefono())->save(new UpdateTelefonoEmpresa($this->container), $telefono, ['empresaID' => $this->id]);

        if ($is_updated === false) {
            return false;
        }

        $this->telefono = $telefono;

        return true;
    }

    private function updateEmail($email)
    {
        if (isset($this->email) === false) {
            $is_saved = (new Email())->save(new SaveNewEmail($this->container), $email, ['empresaID' => $this->id]);

            if ($is_saved === false) {
                return false;
            }

            $this->email = $email;

            return true;
        }

        $is_updated = (new Email())->save(new UpdateEmailEmpresa($this->container), $email, ['empresaID' => $this->id]);

        if ($is_updated === false) {
            return false;
        }

        $this->email = $email;

        return true;
    }

    public function delete()
    {
        return (new DeleteEmpresa($this->container))->write($this->id);
    }
}