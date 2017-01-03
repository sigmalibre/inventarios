<?php

namespace Sigmalibre\IVA;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\Min;
use Respect\Validation\Rules\Numeric;
use Sigmalibre\Validation\Validator;

class IVAValidator extends Validator
{
    /**
     * Realiza las validaciones necesarias para cada caso en específico.
     * Los campos que no pasen la validación deberán ser todos guardados en
     * $invalidUserInputs.
     *
     * @param array $input
     *
     * @return bool True si todos los validadores pasaron la prueba; False sino
     */
    public function validate($input)
    {
        $this->validarPorcentajeIVA($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * El porcentaje del iva debe ser un valor numérico positivo.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validarPorcentajeIVA(array $input)
    {
        $v = new AllOf(
            new Numeric(),
            new Min(0, true)
        );

        if ($v->validate($input['porcentajeIVA']) === false) {
            $this->setInvalidInput('porcentajeIVA');

            return false;
        }

        return true;
    }
}