<?php

namespace Sigmalibre\Products;

use Sigmalibre\DataSource\ReadInterface;
use Sigmalibre\DataSource\WriteInterface;
use Sigmalibre\Validation\Validator;

/**
 * Maneja descuentos aplicados al precio de venta de un producto.
 */
class Descuentos
{
    protected $producto;
    protected $persistenceReader;
    protected $validator;

    /**
     * @param \Sigmalibre\Products\Product         $producto
     * @param \Sigmalibre\DataSource\ReadInterface $persistenceReader
     * @param \Sigmalibre\Validation\Validator     $validator
     *
     * @internal param \Sigmalibre\DataSource\WriteInterface $persistenceWriter
     */
    public function __construct(Product $producto, ReadInterface $persistenceReader, Validator $validator)
    {
        $this->producto = $producto;
        $this->persistenceReader = $persistenceReader;
        $this->validator = $validator;
    }

    /**
     * Crea un nuevo descuento de producto en la fuente de datos.
     *
     * @param array                                 $input
     * @param \Sigmalibre\DataSource\WriteInterface $writer
     *
     * @return bool
     */
    public function escribirDescuento(array $input, WriteInterface $writer)
    {
        if ($this->producto->is_set() === false) {
            $this->validator->setInvalidInput('productoID');

            return false;
        }

        // limpiar los espacios en blanco del input.
        $input = array_map('trim', $input);

        if ($this->validator->validate($input) === false) {
            return false;
        }

        if ((float)$input['cantidadDescontada'] > (float)$this->producto->Utilidad) {
            $this->validator->setInvalidInput('cantidadDescontadaMayorQueUtilidad');

            return false;
        }

        return $writer->write(array_merge(['productoID' => $this->producto->ProductoID], $input));
    }

    /**
     * Obtiene todos los descuentos asociados desde la fuente de datos.
     *
     * @return array|bool
     */
    public function getDescuentos()
    {
        if ($this->producto->is_set() === false) {
            return false;
        }

        return $this->persistenceReader->read([
            'input' => [
                'productoID' => $this->producto->ProductoID,
            ],
        ]);

    }

    /**
     * Obtiene la informaciónsobre un solo descuento de un producto.
     *
     * @param $productoID
     * @param $descuentoID
     *
     * @return array
     */
    public function getSingle($productoID, $descuentoID)
    {
        return $this->persistenceReader->read([
            'input' => [
                'descuentoID' => $descuentoID,
                'productoID' => $productoID,
            ],
        ]);
    }
}