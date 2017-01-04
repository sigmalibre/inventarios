<?php

namespace Sigmalibre\Ingresos;

use Sigmalibre\Products\Product;

class PromedioPonderado
{
    private $producto;
    private $ingreso;

    /**
     * PromedioPonderado constructor.
     *
     * @param Product $producto
     * @param array   $ingreso
     */
    public function __construct(Product $producto, array $ingreso)
    {
        $this->producto = $producto;
        $this->ingreso = $ingreso;
    }

    /**
     * Realiza el cálculo del promedio ponderado, utilizando la cantidad de producto al momento de correr este método,
     * el costo actual del producto y lo promedia con la cantidad y costo del producto nuevo a ingresar.
     *
     * @return float|int
     * @throws \RuntimeException
     */
    public function calcularNuevoCosto()
    {
        if ($this->producto->is_set() === false) {
            throw new \RuntimeException('No se pudo obtener información sobre el producto, no se puede calcular el costo nuevo.');
        }

        if (empty($this->ingreso) === true) {
            throw new \RuntimeException('No se pudo obtener información sobre el costo de la entrada nueva, no se puede calcular el costo total.');
        }

        // Calcular el valor en dinero de el total existente de el producto.
        $saldoActual = (float)$this->producto->Cantidad * (float)$this->producto->CostoActual;
        // Calcula el valor en dinero total de la entrada nueva.
        $saldoEstaCompra = (float)$this->ingreso['cantidadIngreso'] * (float)$this->ingreso['valorPrecioUnitario'];

        // Suma la cantidad existente con la cantidad de producto nueva.
        $cantidadTotal = (float)$this->producto->Cantidad + (float)$this->ingreso['cantidadIngreso'];

        // Si la cantidad de producto existente + nuevo es mayor que cero
        if ($cantidadTotal > 0) {
            // El costo total es la suma de ambos valores en dinero entre la cantidad total de productos que habrá.
            $costoActual = ($saldoActual + $saldoEstaCompra) / $cantidadTotal;
        }

        return $costoActual ?? 0;
    }
}
