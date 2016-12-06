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

    public function save($userInput)
    {
        $validator = $this->container->validator;

        // La unidad de medida del producto debe ser un string de 100 caracteres o menos
        if ($validator::stringType()->length(1, 100)->validate($userInput['unidadMedida']) === false) {
            return false;
        }

        $meassurementesWriter = new DataSource\MySQL\SaveNewUnitOfMeasurement($this->container);

        return $meassurementesWriter->write($userInput);
    }

    public function idFromName($name)
    {
        $meassurementsList = $this->readAllUnitsOfMeasurement();

        // Revisar si ya existe la marca, y obtener su ID.
        foreach ($meassurementsList as $unit) {
            if (strtolower($unit['UnidadMedida']) === strtolower($name)) {
                return $unit['MedidaID'];
            }
        }

        return false;
    }
}
