<?php

namespace Sigmalibre\Reports\ReportBuilders;

use Sigmalibre\Products\Products;
use Sigmalibre\Reports\Reporte;
use Sigmalibre\Reports\ReporteBuilder;

/**
 * Crea reporte de conteo de inventario físico según una categoría de producto.
 */
class ResumenMercaderiaReportBuilder implements ReporteBuilder
{
    private $title;
    private $withHeader;
    private $headerLogoPath;
    private $contentMeta;
    private $contentTitles;
    private $contentBody;
    private $contentFooter;

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function buildTitle()
    {
        $this->title = 'RESUMEN DE EXISTENCIAS';
    }

    public function buildWithHeader()
    {
        $this->withHeader = true;
    }

    public function buildHeaderLogoPath()
    {
        $this->headerLogoPath = 'img/logo_arcoiris.jpg';
    }

    public function buildContentMeta()
    {
        $this->contentMeta = '## Cantidad total de productos y valor en dinero';
    }

    public function buildContentTitles()
    {
        $this->contentTitles = ['Cantidad en Unidades', 'Cantidad en Dinero'];
    }

    public function buildContentBody()
    {
        $productos = new Products($this->container);

        $lista_productos = $productos->readAllProudcts();

        $resumen = array_reduce($lista_productos, function ($carry, $p) {
            $carry[0] += $p['Cantidad']; // Cantidad
            $carry[1] += ($p['Cantidad'] * $p['CostoActual']); // Valor en dinero

            return $carry;
        }, [0, 0]);

        $this->contentBody = [[$resumen[0], '$ ' . number_format($resumen[1], 2)]];
    }

    public function buildContentFooter()
    {
        $this->contentFooter = [];
    }

    public function getReporte()
    {
        $reporte = new Reporte();

        $reporte->title = $this->title;
        $reporte->withHeader = $this->withHeader;
        $reporte->headerLogoPath = $this->headerLogoPath;
        $reporte->contentMeta = $this->contentMeta;
        $reporte->contentTitles = $this->contentTitles;
        $reporte->contentBody = $this->contentBody;
        $reporte->contentFooter = $this->contentFooter;

        return $reporte;
    }
}
