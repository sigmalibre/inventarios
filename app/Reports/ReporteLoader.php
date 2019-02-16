<?php

namespace Sigmalibre\Reports;

use Dompdf\Dompdf;
use Dompdf\Options;
use Sigmalibre\Empresas\Empresa;
use Sigmalibre\UserConfig\ConfigReader;

class ReporteLoader
{
    protected $pdf;
    protected $templates;
    protected $datosEmpresa;
    protected $reportTemplate;
    protected $orientation;

    public function __construct($container, $template='basereport.twig', $orientation='portrait')
    {
        $this->reportTemplate = $template;
        $this->orientation = $orientation;
        $this->templates = new \Twig_Environment(new \Twig_Loader_Filesystem(APP_ROOT . '/app/Views/pdf'));
        $this->datosEmpresa = new Empresa((new ConfigReader())->read('empresa'), $container);

        $this->pdf = new Dompdf();
    }

    public function render(Reporte $reporte, $html_only = false)
    {
        $render = $this->templates->render($this->reportTemplate, [
            'reporte_titulo' => $reporte->title,
            'show_header' => $reporte->withHeader,
            'header_logo_src' => $reporte->headerLogoPath,
            'empresa' => [
                'nombre' => $this->datosEmpresa->getNombre(),
                'giro' => $this->datosEmpresa->getGiro(),
                'registro' => $this->datosEmpresa->getRegistro(),
                'direccion' => $this->datosEmpresa->getDireccion(),
                'telefono' => $this->datosEmpresa->getTelefono(),
            ],
            'header' => [
                'visible' => $reporte->withHeader,
                'logo' => $reporte->headerLogoPath,
            ],
            'content' => [
                'header' => [
                    'meta' => $reporte->contentMeta,
                    'titles' => $reporte->contentTitles,
                ],
                'body' => $reporte->contentBody,
                'footer' => $reporte->contentFooter,
            ],
        ]);

        if ($html_only) {
            return $render;
        }

        $pdfOptions = new Options([
            'isHtml5ParserEnabled' => true
        ]);

        $pdf = new Dompdf($pdfOptions);
        $pdf->loadHtml($render);
        $pdf->setPaper('letter', $this->orientation);
        $pdf->render();

        return $pdf->output();
    }
}
