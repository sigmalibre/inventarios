<?php

namespace Sigmalibre\UnitsOfMeasurement;

class UnitsOfMeasurement
{
    private $container;

    function __construct($container)
    {
        $this->container = $container;
    }

    public function readMesurementList($userInput)
    {
        $listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllFilteredUnitsOfMeasurement($this->container),
            new DataSource\MySQL\FilterAllUnitsOfMeasurement($this->container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );

        $measurementsList = $listReader->read();
        $measurementsList['userInput'] = $userInput;

        return $measurementsList;
    }

    public function readAllUnitsOfMeasurement()
    {
        $measurementesList = new DataSource\MySQL\SearchAllUnitsOfMeasurement($this->container);

        return $measurementesList->read([]);
    }
}
