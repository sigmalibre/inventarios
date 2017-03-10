<?php

namespace Sigmalibre\Reports;

/**
 * Construye reportes a partir de una especificación
 */
class ReporteBuilderDirector
{
    private $builder;

    public function __construct(ReporteBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function make()
    {
        $this->builder->buildTitle();
        $this->builder->buildWithHeader();
        $this->builder->buildHeaderLogoPath();
        $this->builder->buildContentMeta();
        $this->builder->buildContentTitles();
        $this->builder->buildContentBody();
        $this->builder->buildContentFooter();

        return $this->builder->getReporte();
    }
}
