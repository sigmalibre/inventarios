<?php

namespace Sigmalibre\Reports\ReportBuilders;


use Sigmalibre\Reports\Reporte;
use Sigmalibre\Reports\ReporteBuilder;

/**
 * Construye un reporte con valores falsos de prueba.
 */
class CotizacionReportBuilder implements ReporteBuilder
{
    private $title;
    private $withHeader;
    private $headerLogoPath;
    private $contentMeta;
    private $contentTitles;
    private $contentBody;
    private $contentFooter;
    
    private $detalles;

    public function __construct($detalles)
    {
        $this->detalles = $detalles;
    }

    public function buildTitle()
    {
        $this->title = 'DETALLE DE PRODUCTOS';
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
        $this->contentMeta = '## LISTA DE PRODUCTOS';
    }

    public function buildContentTitles()
    {
        $this->contentTitles = ['Codigo', 'Almacén', 'Cantidad', 'Descripción', 'Precio Unitario', 'Ventas Excentas', 'Ventas Afectas'];
    }

    public function buildContentBody()
    {
        $this->contentBody = [
            ['001', 'UNIDAD', 'RASTRILLO METÁLICO', 'SURTEK', 'JARDINERÍA'],
            ['002', 'PAR', 'BOTAS INDUSTRIALES', 'TRUPER', 'PROTECCIÓN'],
            ['003', 'GALÓN', 'PINTURA ROJA', 'COMEX', 'PINTURAS'],
        ];

        $this->contentBody = array_map(function ($d) {
            return [
                $d['codigo'],
                $d['almacen'],
                $d['cantidad'],
                $d['descripcion'],
                '$ ' . number_format($d['precio'], 2),
                '$ ' . number_format($d['excentas'], 2),
                '$ ' . number_format($d['afectas'], 2)
            ];
        }, $this->detalles);
    }

    public function buildContentFooter()
    {
        $afectas = array_reduce($this->detalles, function ($suma, $d) {
            return $suma + $d['afectas'];
        }, 0);

        $exentas = array_reduce($this->detalles, function ($suma, $d) {
            return $suma + $d['excentas'];
        }, 0);


        $this->contentFooter = [
            [
                ['empty' => true, 'colspan' => 5],
                ['head' => true, 'text' => 'SUMAS'],
                ['cell' => true, 'text' => '$ ' . number_format($afectas, 2)],
            ],
            [
                ['empty' => true, 'colspan' => 5],
                ['head' => true, 'text' => 'EXENTAS'],
                ['cell' => true, 'text' => '$ ' . number_format($exentas, 2)],
            ],
            [
                ['empty' => true, 'colspan' => 5],
                ['head' => true, 'text' => 'TOTAL'],
                ['cell' => true, 'text' => '$ ' . number_format($afectas + $exentas, 2)],
            ],
        ];
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
