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
     * @param array $input Input del usuario a validar
     *
     * @return bool True si ha pasado las validaciones; False de lo contrario
     */
    public function validate($input)
    {
        $this->validarCodigo($input);
        $this->validarDescripcion($input);
        $this->validarExcentoIva($input);
        $this->validarStockMin($input);
        $this->validarUtilidad($input);
        $this->validarReferenciaLibroDet($input);
        $this->validarCategoriaDet($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * El código del producto debe ser un string de 1 a 20 caracteres de largo.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validarCodigo($input)
    {
        if ($this->v::stringType()->length(1, 20)->validate($input['codigoProducto']) === false) {
            $this->setInvalidInput('codigoProducto');

            return false;
        }

        return true;
    }

    /**
     * La descripción del producto debe ser un string de 1 a 50 caracteres.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validarDescripcion($input)
    {
        if ($this->v::stringType()->length(1, 50)->validate($input['descripcionProducto']) === false) {
            $this->setInvalidInput('descripcionProducto');

            return false;
        }

        return true;
    }

    /**
     * El producto es excento de IVA, valor opcional ya que por defecto los
     * productos están sin excepción al IVA.
     *
     * Debe ser un valor booleano.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validarExcentoIva($input)
    {
        if ($this->v::optional($this->v::boolVal())->validate($input['excentoIvaProducto']) === false) {
            $this->setInvalidInput('excentoIvaProducto');

            return false;
        }

        return true;
    }

    /**
     * El stock mínimo del producto, esta cantidad se utiliza para enviar una
     * alerta cuando el producto está por terminarse.
     *
     * Debe ser un valor numérico entero positivo incluyendo el cero.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validarStockMin($input)
    {
        if ($this->v::numeric()->intVal()->min(0, true)->validate($input['stockMinProducto']) === false) {
            $this->setInvalidInput('stockMinProducto');

            return false;
        }

        return true;
    }

    /**
     * La utilidad debe ser un valor numérico positvio.Este valor es opcional, y por defecto es 0.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validarUtilidad($input)
    {
        if ($this->v::optional($this->v::numeric()->min(0, true))->validate($input['utilidadProducto']) === false) {
            $this->setInvalidInput('utilidadProducto');

            return false;
        }

        return true;
    }

    /**
     * El código de la referencia del libro DET, debe ser un string de 2 caracteres.
     *
     * @param string $input
     *
     * @return bool
     */
    public function validarReferenciaLibroDet($input)
    {
        if ($this->v::stringType()->noWhitespace()->length(2, 2)->validate($input['referenciaLibroDetProducto']) === false) {
            $this->setInvalidInput('referenciaLibroDetProducto');

            return false;
        }

        return true;
    }

    /**
     * El código del bien DET debe ser un string sin espacios de 2 dígitos de largo.
     *
     * @param string $input
     *
     * @return bool
     */
    public function validarCategoriaDet($input)
    {
        if ($this->v::stringType()->noWhitespace()->length(2, 2)->validate($input['categoriaDetProducto']) === false) {
            $this->setInvalidInput('categoriaDetProducto');

            return false;
        }

        return true;
    }
}
