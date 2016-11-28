<?php

namespace Sigmalibre\Products\DataSource\MySQL;

class ProductWriter implements \Sigmalibre\DataSource\WriteDataSourceInterface
{
    public function write($newDataList)
    {
        return true;
    }

    public function update($identifiers, $newDataToUpdateList)
    {

    }

    public function delete($identifiers)
    {

    }
}
