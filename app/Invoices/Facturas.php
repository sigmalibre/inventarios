<?php

namespace Sigmalibre\Invoices;

use Sigmalibre\Invoices\DetalleFactura\DetalleFacturaBuildingDirector;
use Sigmalibre\Invoices\DetalleFactura\DetalleFacturaFromInputBuilder;
use Sigmalibre\Invoices\DetalleFactura\DetalleFacturaValidator;

/**
 * Modelo para operaciones sobre facturas de consumidor final.
 */
class Facturas
{
    private $repoFacturas;
    private $validador;
    private $validadorDetalle;
    private $container;

    public function __construct(FacturaRepository $repoFacturas, $container)
    {
        $this->repoFacturas = $repoFacturas;
        $this->validador = new ValidadorFacturas();
        $this->validadorDetalle = new DetalleFacturaValidator();
        $this->container = $container;
    }

    /**
     * Obtiene una lista de las facturas aplicando filtros según términos de búsqueda.
     *
     * @param $input
     *
     * @return array
     */
    public function getFiltered($input)
    {
        return $this->repoFacturas->getFiltered($input);
    }

    private function buildFactura($input)
    {
        return new Factura(0, (string)(new \DateTime())->getTimestamp(),
            $input['tipoFacturaID'], $input['tirajeFacturaID'], '', $input['correlativo'],
            $input['clientePersonaID'], '', '', $input['empleadoID'], '', null, null, 0, []);
    }

    private function buildDetalles($input)
    {
        $detalles = [];

        foreach ($input['detalles'] as $detalle) {
            $detalle['detalleID'] = 0;
            $detalle['facturaID'] = 0;
            if ($this->validadorDetalle->validate($detalle) === false) {
                return false;
            }

            $builder = new DetalleFacturaBuildingDirector(new DetalleFacturaFromInputBuilder($this->container, $detalle));
            $detalles[] = $builder->make();
        }

        return $detalles;
    }

    /**
     * Almacena permanentemente una factura recien creada.
     *
     * @param array $input
     *
     * @return bool
     */
    public function newFactura(array $input)
    {
        if ($this->runValidators($input) === false) {
            return false;
        }

        $factura = $this->buildFactura($input);

        $factura->detalles = $this->buildDetalles($input);

        if ($factura->detalles === false) {
            return false;
        }

        return $this->repoFacturas->add($factura);
    }

    private function runValidators($input)
    {
        $this->validador->validate($input);

        return empty($this->getInvalidInput());
    }

    /**
     * En una operacion de escritura hacia una factura, se corren validadores para verificar
     * la validez del input del usuario. Si uno de esos controles falla, este método obtiene
     * los inputs fallidos.
     *
     * @return array
     */
    public function getInvalidInput()
    {
        return array_merge(
            $this->validador->getInvalidInputs(),
            $this->validadorDetalle->getInvalidInputs()
        );
    }
}