<?php

namespace Sigmalibre\Invoices;

class Factura
{
    public $id;
    public $fechaFacturacion;
    public $tipoFacturaID;
    public $tirajeFacturaID;
    public $codigoTiraje;
    public $correlativo;
    public $clienteID;
    public $nombreCliente;
    public $apellidoCliente;
    public $empleadoID;
    public $codigoEmpleado;
    public $empresaID;
    public $nombreEmpresa;
    public $ventaTotal = 0;
    public $detalles = [];
    public $ajuste = 0;

    /**
     * Factura constructor.
     *
     * @param int    $id
     * @param string $fechaFacturacion
     * @param int    $tipoFacturaID
     * @param int    $tirajeFacturaID
     * @param string $codigoTiraje
     * @param int    $correlativo
     * @param int    $clienteID
     * @param string $nombreCliente
     * @param string $apellidoCliente
     * @param int    $empleadoID
     * @param string $codigoEmpleado
     * @param int    $empresaID
     * @param string $nombreEmpresa
     * @param float  $ventaTotal
     * @param array  $detalles
     */
    public function __construct(int $id, string $fechaFacturacion, int $tipoFacturaID, int $tirajeFacturaID, string $codigoTiraje, int $correlativo, $clienteID, $nombreCliente, $apellidoCliente, $empleadoID, $codigoEmpleado, $empresaID, $nombreEmpresa, float $ventaTotal, array $detalles, $ajuste)
    {
        $this->id = $id;
        $this->fechaFacturacion = $fechaFacturacion;
        $this->tipoFacturaID = $tipoFacturaID;
        $this->tirajeFacturaID = $tirajeFacturaID;
        $this->codigoTiraje = $codigoTiraje;
        $this->correlativo = $correlativo;
        $this->clienteID = $clienteID;
        $this->nombreCliente = $nombreCliente;
        $this->apellidoCliente = $apellidoCliente;
        $this->empleadoID = $empleadoID;
        $this->codigoEmpleado = $codigoEmpleado;
        $this->empresaID = $empresaID;
        $this->nombreEmpresa = $nombreEmpresa;
        $this->ventaTotal = $ventaTotal;
        $this->detalles = $detalles;
        $this->ajuste = $ajuste;
    }
}