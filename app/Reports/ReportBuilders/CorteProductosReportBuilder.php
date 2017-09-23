<?php

namespace Sigmalibre\Reports\ReportBuilders;

use PHPExtra\Sorter\Sorter;
use PHPExtra\Sorter\Strategy\ComplexSortStrategy;
use Sigmalibre\Products\Products;
use Sigmalibre\Reports\Reporte;
use Sigmalibre\Reports\ReporteBuilder;

/**
 * Crea reporte de conteo de inventario físico según una categoría de producto.
 */
class CorteProductosReportBuilder implements ReporteBuilder
{
    private $title;
    private $withHeader;
    private $headerLogoPath;
    private $contentMeta;
    private $contentTitles;
    private $contentBody;
    private $contentFooter;

    private $container;
    private $category;
    private $orderby;

    private $totalCostos = 0;

    public function __construct($container, $category, $orderby)
    {
        $this->container = $container;
        $this->category = $category;
        $this->orderby = $orderby;
    }

    public function buildTitle()
    {
        $this->title = 'CONTEO DE INVENTARIO';
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
        $this->contentMeta = '## LISTA CONTEO DE PRODUCTOS';
    }

    public function buildContentTitles()
    {
        $this->contentTitles = ['Código', 'Categoría', 'Medida', 'Producto', 'Marca', 'Unidades', 'Precio Unitario', 'Total Item'];
    }

    public function buildContentBody()
    {
        $productos = new Products($this->container);

        $lista_productos = $productos->readAllProudctsUnfiltered([
            'codigoCategoria' => $this->category,
        ]);

        $lista_productos = array_map(function ($p) {
            return (object) $p;
        }, $lista_productos);

        $sorting_strategy = new ComplexSortStrategy();
        $sorting_strategy
            ->setSortOrder(Sorter::ASC)
            ->sortBy($this->orderby);

        $sorter = new Sorter();

        $lista_productos = $sorter->setStrategy($sorting_strategy)->sort($lista_productos);

        $this->contentBody = array_map(function ($p) {
            $this->totalCostos += $p->Cantidad * $p->CostoActual;
            return [
                $p->CodigoProducto,
                $p->NombreCategoria,
                $p->UnidadMedida,
                $p->Descripcion,
                $p->NombreMarca,
                $p->Cantidad . ' ' . $p->UnidadMedida,
                '$ ' . number_format($p->CostoActual, 2),
                '$ ' . number_format($p->Cantidad * $p->CostoActual, 2),
            ];
        }, $lista_productos);
    }

    public function buildContentFooter()
    {
        $this->contentFooter = [
            [
                ['head' => true, 'text' => 'TOTAL CATEGORÍA'],
                ['empty' => true, 'colspan' => 6],
                ['cell' => true, 'text' => '$ ' . number_format($this->totalCostos, 2)],
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
