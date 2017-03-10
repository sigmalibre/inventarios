<?php

namespace Sigmalibre\Reports\ReportBuilders;


use Sigmalibre\Reports\Reporte;
use Sigmalibre\Reports\ReporteBuilder;

/**
 * Construye un reporte con valores falsos de prueba.
 */
class TestReportBuilder implements ReporteBuilder
{
    private $title;
    private $withHeader;
    private $headerLogoPath;
    private $contentMeta;
    private $contentTitles;
    private $contentBody;
    private $contentFooter;

    public function buildTitle()
    {
        $this->title = 'REPORTE LISTA PRODUCTOS (PRUEBA)';
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
        $this->contentMeta = '## LISTA DE PRODUCTOS (REPORTE DE PRUEBA)';
    }

    public function buildContentTitles()
    {
        $this->contentTitles = ['Codigo', 'Medida', 'Descripción', 'Marca', 'Categoría'];
    }

    public function buildContentBody()
    {
        $this->contentBody = [
            ['001', 'UNIDAD', 'RASTRILLO METÁLICO', 'SURTEK', 'JARDINERÍA'],
            ['002', 'PAR', 'BOTAS INDUSTRIALES', 'TRUPER', 'PROTECCIÓN'],
            ['003', 'GALÓN', 'PINTURA ROJA', 'COMEX', 'PINTURAS'],
        ];
    }

    public function buildContentFooter()
    {
        $this->contentFooter = [
            [
                ['empty' => true, 'colspan' => 3],
                ['head' => true, 'text' => 'SUMAS'],
                ['cell' => true, 'text' => '$ ' . 524.23],
            ],
            [
                ['empty' => true, 'colspan' => 3],
                ['head' => true, 'text' => 'TOTAL'],
                ['cell' => true, 'text' => '$ ' . 524.25],
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
