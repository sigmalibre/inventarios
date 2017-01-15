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
    protected $persistenceWriter;
    protected $persistenceReader;
    protected $validator;

    /**
     * @param \Sigmalibre\Products\Product          $producto
     * @param \Sigmalibre\DataSource\WriteInterface $persistenceWriter
     * @param \Sigmalibre\DataSource\ReadInterface  $persistenceReader
     * @param \Sigmalibre\Validation\Validator      $validator
     */
    public function __construct(Product $producto, WriteInterface $persistenceWriter, ReadInterface $persistenceReader, Validator $validator)
    {
        $this->producto = $producto;
        $this->persistenceWriter = $persistenceWriter;
        $this->persistenceReader = $persistenceReader;
        $this->validator = $validator;
    }

    /**
     * Crea un nuevo descuento de producto en la fuente de datos.
     *
     * @param array $input
     *
     * @return bool
     */
    public function crearDescuento(array $input)
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

        return $this->persistenceWriter->write(array_merge(['productoID' => $this->producto->ProductoID], $input));
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
}