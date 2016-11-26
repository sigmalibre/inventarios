<?php

namespace Sigmalibre\DETCategories;

class DETCategories
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function readAllDETCategories()
    {
        $detCategoryList = new DataSource\MySQL\SearchAllDETCategories($this->container);

        return $detCategoryList->read([]);
    }
}
