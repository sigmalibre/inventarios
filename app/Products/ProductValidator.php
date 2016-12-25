<?php

namespace Sigmalibre\Products;

/**
 * Maneja la validación de datos para las distintas acciones sobre productos.
 */
class ProductValidator extends \Sigmalibre\Validation\Validator
{
    /**
     * Realiza las validaciones específicas para crear un nuevo producto.
     *
     * @param array $userInput Input del usuario a validar
     *
     * @return bool True si ha pasado las validaciones; False de lo contrario
     */
    public function validateNewProduct($userInput)
    {
        $validator = $this->container->validator;

        // El código del producto debe ser un string de 1 a 20 caracteres de largo.
        if ($validator::stringType()->length(1, 20)->validate($userInput['codigoProducto']) === false) {
            $this->invalidUserInputs['codigoProducto'] = true;

            return false;
        }

        // La descripción del producto debe ser un string de 1 a 30 caracteres.
        if ($validator::stringType()->length(1, 50)->validate($userInput['descripcionProducto']) === false) {
            $this->invalidUserInputs['descripcionProducto'] = true;

            return false;
        }

        // El producto es excento de IVA, valor opcional ya que por defecto los productos están sin excepción al IVA.
        // Debe ser un valor booleano.
        if ($validator::optional($validator::boolVal())->validate($userInput['excentoIvaProducto']) === false) {
            $this->invalidUserInputs['excentoIvaProducto'] = true;

            return false;
        }

        // El stock mínimo del producto, esta cantidad se utiliza para enviar una alerta cuando el producto está por terminarse.
        // Debe ser un valor numérico entero positivo incluyendo el cero.
        if ($validator::numeric()->intVal()->min(0, true)->validate($userInput['stockMinProducto']) === false) {
            $this->invalidUserInputs['stockMinProducto'] = true;

            return false;
        }

        // El código de la referencia del libro DET, debe ser un string de 2 caracteres.
        if ($validator::stringType()->noWhitespace()->length(2, 2)->validate($userInput['referenciaLibroDetProducto']) === false) {
            $this->invalidUserInputs['referenciaLibroDetProducto'] = true;

            return false;
        }

        // El código del bien DET debe ser un string sin espacios de 2 dígitos de largo.
        if ($validator::stringType()->noWhitespace()->length(2, 2)->validate($userInput['categoriaDetProducto']) === false) {
            $this->invalidUserInputs['categoriaDetProducto'] = true;

            return false;
        }

        // La marca del producto debe ser un string de 100 caracteres o menos
        if ($validator::stringType()->length(1, 100)->validate($userInput['marcaProducto']) === false) {
            $this->invalidUserInputs['marcaProducto'] = true;

            return false;
        }

        // La medida del producto debe ser un string de 100 caracteres o menos
        if ($validator::stringType()->length(1, 100)->validate($userInput['medidaProducto']) === false) {
            $this->invalidUserInputs['medidaProducto'] = true;

            return false;
        }

        // El código de la categoría debe ser un string sin espacios de 2 dígitos de largo.
        if ($validator::stringType()->noWhitespace()->length(2, 2)->validate($userInput['categoriaProducto']) === false) {
            $this->invalidUserInputs['categoriaProducto'] = true;

            return false;
        }

        return true;
    }
}
