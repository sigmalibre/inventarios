<?php

namespace Sigmalibre\Empleados;

use Sigmalibre\DatosGenerales\Email;
use Sigmalibre\Pagination\Paginator;
use Sigmalibre\DatosGenerales\Telefono;
use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\DatosGenerales\Direccion;
use Sigmalibre\DatosGenerales\ValidadorEmails;
use Sigmalibre\DatosGenerales\ValidadorTelefono;
use Sigmalibre\DatosGenerales\ValidadorDireccion;
use Sigmalibre\Empleados\DataSource\GetFacturas;
use Sigmalibre\Empleados\DataSource\DeleteEmpleado;
use Sigmalibre\Empleados\DataSource\UpdateEmpleado;
use Sigmalibre\Empleados\DataSource\FilterEmpleados;
use Sigmalibre\Empleados\DataSource\SaveNewEmpleado;
use Sigmalibre\Empleados\DataSource\GetEmpleadoFromID;
use Sigmalibre\Empleados\DataSource\SearchAllEmpleados;
use Sigmalibre\Empleados\DataSource\CountFilteredEmpleados;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewEmail;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewTelefono;
use Sigmalibre\DatosGenerales\DataSource\MySQL\SaveNewDireccion;
use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateEmailEmpleado;
use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateTelefonoEmpleado;
use Sigmalibre\DatosGenerales\DataSource\MySQL\UpdateDireccionEmpleado;

class Empleados
{
	private $container;
	private $validador;
	private $validadorDirecciones;
	private $validadorTelefonos;
	private $validadorEmails;
	private $empleado;

	public function __construct($container)
	{
		$this->container = $container;
		$this->validador = new ValidadorEmpleados();
		$this->validadorDirecciones = new ValidadorDireccion();
		$this->validadorTelefonos = new ValidadorTelefono();
		$this->validadorEmails = new ValidadorEmails();
	}

	public function getFiltered($input)
	{
		$reader = new ItemListReader(
			new CountFilteredEmpleados($this->container),
			new FilterEmpleados($this->container),
			new Paginator($input),
			$input
		);

		$itemList = $reader->read();
		$itemList['userInput'] = $input;

		return $itemList;
	}

	public function getAll()
	{
		$reader = new SearchAllEmpleados($this->container);

		return $reader->read([]);
	}

	public function save($input) {
		$input = array_map('trim', $input);

		$isInputValid = $this->runValidators($input);
		if ($isInputValid === false) {
			return false;
		}

		$this->container->mysql->beginTransaction();

		$newEmpleadoID = $this->saveEmpleado($input);
		if ($newEmpleadoID === false) {
			$this->container->mysql->rollBack();

			return false;
		}

		if (!empty($input['direccion'])) {
			$newDireccionID = (new Direccion())->save(new SaveNewDireccion($this->container), $input['direccion'], ['empleadoID' => $newEmpleadoID]);
		}
		if (!empty($input['telefono'])) {
			$newTelefonoID = (new Telefono())->save(new SaveNewTelefono($this->container), $input['telefono'], ['empleadoID' => $newEmpleadoID]);
		}
		if (!empty($input['email'])) {
			$newEmailID = (new Email())->save(new SaveNewEmail($this->container), $input['email'], ['empleadoID' => $newEmpleadoID]);
		}

		$this->container->mysql->commit();

		return true;
	}

	public function runValidators($input)
	{
		$this->validador->validate($input);
		if (!empty($input['direccion'])) {
			$this->validadorDirecciones->validate($input);
		}
		if (!empty($input['telefono'])) {
			$this->validadorTelefonos->validate($input);
		}
		if (!empty($input['email'])) {
			$this->validadorEmails->validate($input);
		}

		return empty($this->getInvalidInputs());
	}

	public function getInvalidInputs()
	{
		return array_merge(
			$this->validador->getInvalidInputs(),
			$this->validadorDirecciones->getInvalidInputs(),
			$this->validadorTelefonos->getInvalidInputs(),
			$this->validadorEmails->getInvalidInputs()
		);
	}

	private function saveEmpleado($input)
	{
		return (new SaveNewEmpleado($this->container))->write([
			'nombres' => $input['nombres'],
			'apellidos' => $input['apellidos'],
			'dui' => $input['dui'],
			'nit' => $input['nit'],
			'nup' => $input['nup'],
			'isss' => $input['isss'],
			'codigo' => $input['codigo'],
		]);
	}

	public function update($id, $input) {
		$input = array_map('trim', $input);

		$this->getEmpleado($id);
		if (!$this->empleado) {
			return false;
		}

		$isInputValid = $this->runValidators($input);
		if ($isInputValid === false) {
			return false;
		}

		$this->container->mysql->beginTransaction();

		$isEmpleadoUpdated = $this->updateEmpleado($input);

		if ($isEmpleadoUpdated === false) {
			$this->container->mysql->rollBack();

			return false;
		}

		$isDireccionUpdated = $this->updateDireccion($input['direccion']);
		$isTelefonoUpdated = $this->updateTelefono($input['telefono']);
		$isEmailUpdated = $this->updateEmail($input['email']);

		$this->container->mysql->commit();

		return true;
	}

	public function getEmpleado($id) {
		if (!$id) {
			return false;
		}

		$dataSource = new GetEmpleadoFromID($this->container);
		$found = $dataSource->read([
			'input' => [
				'idEmpleado' => $id,
			],
		]);

		if ($found === false || isset($found[0]) === false) {
			return false;
		}

		$this->empleado = $found[0];
		return $found[0];
	}

	private function updateEmpleado($input)
	{
		return (new UpdateEmpleado($this->container))->write([
			'id' => $this->empleado['EmpleadoID'],
			'nombres' => $input['nombres'],
			'apellidos' => $input['apellidos'],
			'dui' => $input['dui'],
			'nit' => $input['nit'],
			'nup' => $input['nup'],
			'isss' => $input['isss'],
			'codigo' => $input['codigo'],
		]);
	}

	private function updateDireccion($direccion)
	{
		if (isset($this->empleado['Direccion']) === false) {
			$is_saved = (new Direccion())->save(new SaveNewDireccion($this->container), $direccion, ['empleadoID' => $this->empleado['EmpleadoID']]);

			if ($is_saved === false) {
				return false;
			}

			$this->empleado['Direccion'] = $direccion;

			return true;
		}

		$is_updated = (new Direccion())->save(new UpdateDireccionEmpleado($this->container), $direccion, ['empleadoID' => $this->empleado['EmpleadoID']]);

		if ($is_updated === false) {
			return false;
		}

		$this->empleado['Direccion'] = $direccion;

		return true;
	}

	private function updateTelefono($telefono)
    {
        if (isset($this->empleado['Telefono']) === false) {
            $is_saved = (new Telefono())->save(new SaveNewTelefono($this->container), $telefono, ['empleadoID' => $this->empleado['EmpleadoID']]);

            if ($is_saved === false) {
                return false;
            }

            $this->empleado['Telefono'] = $telefono;

            return true;
        }

        $is_updated = (new Telefono())->save(new UpdateTelefonoEmpleado($this->container), $telefono, ['empleadoID' => $this->empleado['EmpleadoID']]);

        if ($is_updated === false) {
            return false;
        }

        $this->empleado['Telefono'] = $telefono;

        return true;
	}
	
	private function updateEmail($email)
    {
        if (isset($this->empleado['Email']) === false) {
            $is_saved = (new Email())->save(new SaveNewEmail($this->container), $email, ['empleadoID' => $this->empleado['EmpleadoID']]);

            if ($is_saved === false) {
                return false;
            }

            $this->empleado['Email'] = $email;

            return true;
        }

        $is_updated = (new Email())->save(new UpdateEmailEmpleado($this->container), $email, ['empleadoID' => $this->empleado['EmpleadoID']]);

        if ($is_updated === false) {
            return false;
        }

        $this->empleado['Email'] = $email;

        return true;
	}
	
	public function delete($id) {
		return (new DeleteEmpleado($this->container))->write($id);
	}

	public function getRendimiento($fecha) {
		$dia = date('d', strtotime($fecha));
        $mes = date('m', strtotime($fecha));
		$ano = date('Y', strtotime($fecha));

		$dataSource = new GetFacturas($this->container);
		$facturas = $dataSource->read($ano);

		$rendimiento = [];

		foreach ($facturas as $factura) {
			if (isset($rendimiento[$factura['EmpleadoID']]) === false) {
				$rendimiento[$factura['EmpleadoID']]['codigo'] = $factura['Codigo'] ?? '--';
				$rendimiento[$factura['EmpleadoID']]['nombre'] = $factura['Empleado'] ?? 'Sin empleado';
				$rendimiento[$factura['EmpleadoID']]['dia']['cantidad'] = 0;
				$rendimiento[$factura['EmpleadoID']]['dia']['valor'] = 0;
				$rendimiento[$factura['EmpleadoID']]['mes']['cantidad'] = 0;
				$rendimiento[$factura['EmpleadoID']]['mes']['valor'] = 0;
				$rendimiento[$factura['EmpleadoID']]['ano']['cantidad'] = 0;
				$rendimiento[$factura['EmpleadoID']]['ano']['valor'] = 0;
			}

			$dia_factura = date('d', strtotime($factura['FechaFacturacion']));
			$mes_factura = date('m', strtotime($factura['FechaFacturacion']));
			$ano_factura = date('Y', strtotime($factura['FechaFacturacion']));

			if ($dia === $dia_factura) {
				$rendimiento[$factura['EmpleadoID']]['dia']['cantidad'] += 1;
				$rendimiento[$factura['EmpleadoID']]['dia']['valor'] += $factura['Total'];
			}

			if ($mes === $mes_factura) {
				$rendimiento[$factura['EmpleadoID']]['mes']['cantidad'] += 1;
				$rendimiento[$factura['EmpleadoID']]['mes']['valor'] += $factura['Total'];
			}

			$rendimiento[$factura['EmpleadoID']]['ano']['cantidad'] += 1;
			$rendimiento[$factura['EmpleadoID']]['ano']['valor'] += $factura['Total'];
		}

		return $rendimiento;
	}
}