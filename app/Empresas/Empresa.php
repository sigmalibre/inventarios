<?php

namespace Sigmalibre\Empresas;

use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateDireccionEmpresa;
use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateEmailEmpresa;
use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateTelefonoEmpresa;
use Sigmalibre\DatosGenerales\Direccion;
use Sigmalibre\DatosGenerales\Email;
use Sigmalibre\DatosGenerales\Telefono;
use Sigmalibre\DatosGenerales\ValidadorDireccion;
use Sigmalibre\DatosGenerales\ValidadorEmails;
use Sigmalibre\DatosGenerales\ValidadorTelefono;
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
                'idEmpresa' => $id,
            ],
        ]);

        if ($attributes === false) {
            return false;
        }

        $this->id = $attributes[0]['EmpresaID'];
        $this->nombre = $attributes[0]['NombreComercial'];
        $this->razonSocial = $attributes[0]['RazonSocial'];
        $this->giro = $attributes[0]['Giro'];
        $this->registro = $attributes[0]['Registro'];
        $this->nit = $attributes[0]['NIT'];
        $this->direccion = $attributes[0]['Direccion'];
        $this->telefono = $attributes[0]['Telefono'];
        $this->email = $attributes[0]['Email'];

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

        $isDireccionUpdated = (new Direccion())->save(new UpdateDireccionEmpresa($this->container), $input['direccion'], ['empresaID' => $this->id]);
        $isTelefonoUpdated = (new Telefono())->save(new UpdateTelefonoEmpresa($this->container), $input['telefono'], ['empresaID' => $this->id]);
        $isEmailUpdated = (new Email())->save(new UpdateEmailEmpresa($this->container), $input['email'], ['empresaID' => $this->id]);

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
}