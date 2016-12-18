<?php

namespace Sigmalibre\TirajeFactura;

class TirajeValidator extends \Sigmalibre\Validation\Validator
{
    /**
     * Realiza validaciones específicas para crear y modificar un tiraje de factura.
     *
     * @param array $userInput Input del usuario a validar
     *
     * @return bool True si ha aprovado las validaciones; False de lo contrario
     */
    public function validate($userInput)
    {
        $validator = $this->container->validator;

        // El código del tiraje debe ser un string de 50 caracteres o menos.
        if ($validator::stringType()->length(1, 50)->validate($userInput['codigoTiraje']) === false) {
            return false;
        }

        // TirajeDesde debe ser un entero positivo.
        if ($validator::numeric()->intVal()->min(1, true)->validate($userInput['tirajeDesde']) === false) {
            return false;
        }

        // TirajeHasta debe ser un entero positivo.
        if ($validator::numeric()->intVal()->min(1, true)->validate($userInput['tirajeHasta']) === false) {
            return false;
        }
    }
}
