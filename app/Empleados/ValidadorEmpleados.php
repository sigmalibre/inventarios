<?php

namespace Sigmalibre\Empleados;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\Length;
use Sigmalibre\Validation\Validator;
use Respect\Validation\Rules\Optional;
use Respect\Validation\Rules\StringType;

class ValidadorEmpleados extends Validator
{
	public function validate($input)
	{
        $this->validarNombres($input);
        $this->validarApellidos($input);
        $this->validarDUI($input);
        $this->validarNIT($input);
        $this->validarNUP($input);
        $this->validarISSS($input);
        $this->validarCodigo($input);

		return empty($this->invalidUserInputs);
	}

	public function validarNombres($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 255, true)
        );

        if ($v->validate($input['nombres']) === false) {
            $this->setInvalidInput('nombres');

            return false;
        }

        return true;
    }

	public function validarApellidos($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 255, true)
        );

        if ($v->validate($input['apellidos']) === false) {
            $this->setInvalidInput('apellidos');

            return false;
        }

        return true;
	}
	
	public function validarDUI($input)
    {
        $v = new Optional(
            new AllOf(
                new StringType(),
                new Length(1, 15, true)
            )
        );

        if ($v->validate($input['dui']) === false) {
            $this->setInvalidInput('dui');

            return false;
        }

        return true;
	}
	
	public function validarNIT($input)
    {
        $v = new Optional(
            new AllOf(
                new StringType(),
                new Length(1, 20, true)
            )
        );

        if ($v->validate($input['nit']) === false) {
            $this->setInvalidInput('nit');

            return false;
        }

        return true;
	}
	
	public function validarNUP($input)
    {
        $v = new Optional(
            new AllOf(
                new StringType(),
                new Length(1, 25, true)
            )
        );

        if ($v->validate($input['nup']) === false) {
            $this->setInvalidInput('nup');

            return false;
        }

        return true;
	}
	
	public function validarISSS($input)
    {
        $v = new Optional(
            new AllOf(
                new StringType(),
                new Length(1, 15, true)
            )
        );

        if ($v->validate($input['isss']) === false) {
            $this->setInvalidInput('isss');

            return false;
        }

        return true;
	}
	
	public function validarCodigo($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 5, true)
        );

        if ($v->validate($input['codigo']) === false) {
            $this->setInvalidInput('codigo');

            return false;
        }

        return true;
	}
}