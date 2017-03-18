<?php

namespace Sigmalibre\Reports;

/**
 * Constructor de reportes
 */
interface ReporteBuilder
{
    public function buildTitle();

    public function buildWithHeader();

    public function buildHeaderLogoPath();

    public function buildContentMeta();

    public function buildContentTitles();

    public function buildContentBody();

    public function buildContentFooter();

    public function getReporte();
}
