<?php

namespace Sigmalibre\TirajeFactura;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\IntVal;
use Respect\Validation\Rules\Length;
use Respect\Validation\Rules\Min;
use Respect\Validation\Rules\Numeric;
use Respect\Validation\Rules\StringType;
use Sigmalibre\Validation\Validator;

class TirajeValidator extends Validator
{
    /**
     * Realiza validaciones específicas para crear y modificar un tiraje de factura.
     *
     * @param array $input Input del usuario a validar
     *
     * @return bool True si ha aprovado las validaciones; False de lo contrario
     */
    public function validate($input)
    {
        $this->validarCodigo($input);
        $this->validarTirajeDesde($input);
        $this->validarTirajeHasta($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * El código del tiraje debe ser un string de 50 carácteres o menos.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validarCodigo($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 50)
        );

        if ($v->validate($input['codigoTiraje']) === false) {
            $this->setInvalidInput('codigoTiraje');

            return false;
        }

        return true;
    }

    /**
     * TirajeDesde debe ser un entero positivo.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validarTirajeDesde($input)
    {
        $v = new AllOf(
            new Numeric(),
            new IntVal(),
            new Min(1, true)
        );

        if ($v->validate($input['tirajeDesde']) === false) {
            $this->setInvalidInput('tirajeDesde');

            return false;
        }
        return true;
    }

    /**
     * TirajeHasta debe ser un entero positivo.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validarTirajeHasta($input)
    {
        $v = new AllOf(
            new Numeric(),
            new IntVal(),
            new Min(1, true)
        );

        if ($v->validate($input['tirajeHasta']) === false) {
            $this->setInvalidInput('tirajeHasta');

            return false;
        }

        return true;
    }
}
