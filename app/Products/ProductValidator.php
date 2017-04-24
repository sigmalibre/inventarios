<?php

namespace Sigmalibre\Products;

use Respect\Validation\Rules\AllOf;
use Respect\Validation\Rules\BoolVal;
use Respect\Validation\Rules\IntVal;
use Respect\Validation\Rules\Length;
use Respect\Validation\Rules\Min;
use Respect\Validation\Rules\NoWhitespace;
use Respect\Validation\Rules\Numeric;
use Respect\Validation\Rules\Optional;
use Respect\Validation\Rules\StringType;
use Sigmalibre\Validation\Validator;

/**
 * Maneja la validación de datos para las distintas acciones sobre productos.
 */
class ProductValidator extends Validator
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
        $this->validarActivo($input);
        $this->validarStockMin($input);
        $this->validarUtilidad($input);
        $this->validarReferenciaLibroDet($input);
        $this->validarCategoriaDet($input);

        return empty($this->invalidUserInputs);
    }

    /**
     * El código del producto debe ser un string de 1 a 20 carácteres de largo.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validarCodigo($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 20)
        );

        if ($v->validate($input['codigoProducto']) === false) {
            $this->setInvalidInput('codigoProducto');

            return false;
        }

        return true;
    }

    /**
     * La descripción del producto debe ser un string de 1 a 29 carácteres.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validarDescripcion($input)
    {
        $v = new AllOf(
            new StringType(),
            new Length(1, 50)
        );

        if ($v->validate($input['descripcionProducto']) === false) {
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
        $v = new AllOf(
            new Optional(new BoolVal())
        );

        if ($v->validate($input['excentoIvaProducto']) === false) {
            $this->setInvalidInput('excentoIvaProducto');

            return false;
        }

        return true;
    }

    /**
     * El valor de activo o inactivo de un producto debe ser un valor booleano.
     *
     * @param $input
     *
     * @return bool
     */
    public function validarActivo($input)
    {
        $v = new Optional(new BoolVal());
        if ($v->validate($input['productoActivo'] ?? null) === false) {
            $this->setInvalidInput('productoActivo');

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
        $v = new AllOf(
            new Numeric(),
            new IntVal(),
            new Min(0, true)
        );

        if ($v->validate($input['stockMinProducto']) === false) {
            $this->setInvalidInput('stockMinProducto');

            return false;
        }

        return true;
    }

    /**
     * La utilidad debe ser un valor numérico positivo.Este valor es opcional, y por defecto es 0.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function validarUtilidad($input)
    {
        $v = new Optional(
            new AllOf(
                new Numeric(),
                new Min(0, true)
            )
        );

        if ($v->validate($input['utilidadProducto']) === false) {
            $this->setInvalidInput('utilidadProducto');

            return false;
        }

        return true;
    }

    /**
     * El código de la referencia del libro DET, debe ser un string de 2 carácteres.
     *
     * @param string $input
     *
     * @return bool
     */
    public function validarReferenciaLibroDet($input)
    {
        $v = new AllOf(
            new StringType(),
            new NoWhitespace(),
            new Length(2, 2)
        );

        if ($v->validate($input['referenciaLibroDetProducto']) === false) {
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
        $v = new AllOf(
            new StringType(),
            new NoWhitespace(),
            new Length(2, 2)
        );

        if ($v->validate($input['categoriaDetProducto']) === false) {
            $this->setInvalidInput('categoriaDetProducto');

            return false;
        }

        return true;
    }
}
