<?php

namespace Sigmalibre\Reports;

use Dompdf\Dompdf;
use Sigmalibre\Empresas\Empresa;
use Sigmalibre\UserConfig\ConfigReader;

class ReporteLoader
{
    protected $pdf;
    protected $templates;
    protected $datosEmpresa;

    public function __construct($container)
    {
        $this->templates = new \Twig_Environment(new \Twig_Loader_Filesystem(APP_ROOT . '/app/Views/pdf'));
        $this->datosEmpresa = new Empresa((new ConfigReader())->read('empresa'), $container);

        $this->pdf = new Dompdf();
    }

    public function render(Reporte $reporte)
    {
        $render = $this->templates->render('basereport.twig', [
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

        $pdf = new Dompdf();

        $pdf->loadHtml($render);

        $pdf->setPaper('letter');

        $pdf->render();

        return $pdf->output();
    }
}
