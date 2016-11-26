<?php

namespace Sigmalibre\DETReferences;

class DETReferences
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function readAllDETReferences()
    {
        $detCategoryList = new DataSource\MySQL\SearchAllDETReferences($this->container);

        return $detCategoryList->read([]);
    }
}
