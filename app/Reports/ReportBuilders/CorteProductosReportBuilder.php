<?php

namespace Sigmalibre\Reports\ReportBuilders;

use PHPExtra\Sorter\Sorter;
use PHPExtra\Sorter\Strategy\ComplexSortStrategy;
use Sigmalibre\Products\Products;
use Sigmalibre\Reports\Reporte;
use Sigmalibre\Reports\ReporteBuilder;
use Sigmalibre\IVA\IVA;

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
    private $brand;
    private $orderby;
    private $columns;

    private $totalCostos = 0;

    public function __construct($container, $category, $brand, $orderby, $columns)
    {
        $this->container = $container;
        $this->category = $category;
        $this->brand = $brand;
        $this->orderby = $orderby;
        $this->columns = $columns;
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
        $this->contentTitles = ['Código'];

        if (in_array('barra', $this->columns)) {
            $this->contentTitles = array_merge(
                $this->contentTitles,
                ['Barra']
            );
        }

        $this->contentTitles = array_merge(
            $this->contentTitles,
            ['Categoría', 'Producto', 'Marca', 'Cantidad', 'Medida']
        );

        if (in_array('costo', $this->columns)) {
            $this->contentTitles = array_merge(
                $this->contentTitles,
                ['Costo Unitario', 'Total de Compra']
            );
        }

        if (in_array('venta', $this->columns)) {
            $this->contentTitles = array_merge(
                $this->contentTitles,
                ['Precio Venta']
            );
        }

        if (in_array('diferencia', $this->columns)) {
            $this->contentTitles = array_merge(
                $this->contentTitles,
                ['% Diferencia', 'Diferencia $$$']
            );
        }
    }

    public function buildContentBody()
    {
        $productos = new Products($this->container);
        $iva = (new IVA())->getPorcentajeIVA() ?? 0;

        $lista_productos = $productos->readAllProudctsUnfiltered([
            'codigoCategoria' => $this->category,
            'marcaID' => $this->brand,
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

        $this->contentBody = array_map(function ($p) use ($iva) {
            $this->totalCostos += $p->Cantidad * $p->CostoActual;

            $body = [$p->CodigoProducto];

            if (in_array('barra', $this->columns)) {
                $body = array_merge(
                    $body,
                    [$p->Barra]
                );
            }

            $body = array_merge(
                $body,
                [
                    $p->NombreCategoria,
                    $p->Descripcion,
                    $p->NombreMarca,
                    $p->Cantidad,
                    $p->UnidadMedida,
                ]
            );

            if (in_array('costo', $this->columns)) {
                $body = array_merge(
                    $body,
                    ['$ ' . number_format($p->CostoActual, 2), '$ ' . number_format($p->Cantidad * $p->CostoActual, 2)]
                );
            }

            $pv = 0;
            if ($p->ExcentoIVA == 1) {
                $pv = $p->CostoActual + $p->Utilidad;
            } else {
                $pv = ($p->CostoActual + $p->Utilidad) * (1 + $iva / 100);
            }
            if (in_array('venta', $this->columns)) {
                $body = array_merge(
                    $body,
                    ['$ ' . number_format($pv, 2)]
                );
            }

            if (in_array('diferencia', $this->columns)) {
                $diff = $pv - $p->CostoActual;
                $diffx100 = ($diff / $p->CostoActual) * 100;
                $body = array_merge(
                    $body,
                    [
                        number_format(is_nan($diffx100) ? 0 : $diffx100, 2) . '%',
                        '$ ' . number_format($diff, 2),
                    ]
                );
            }

            return $body;
        }, $lista_productos);
    }

    public function buildContentFooter()
    {
        $this->contentFooter = [
            [
                ['head' => true, 'text' => 'SUMATORIA TOTAL DE COMPRAS', 'colspan' => count($this->contentTitles) - 1],
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
