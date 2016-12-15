<?php

namespace Sigmalibre\UnitsOfMeasurement;

/**
 * Modelo para las operaciones sobre las unidades de medida.
 */
class UnitsOfMeasurement
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Obtiene una lista con los resultados de la búsqueda de unidades de medida
     * limitados según la paginación.
     *
     * @param array $userInput Términos de búsqueda aplicados por el usuario
     *
     * @return array
     */
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

    /**
     * Obtiene una lista con todas las unidades de medida existentes.
     *
     * @return array
     */
    public function readAllUnitsOfMeasurement()
    {
        $measurementesList = new DataSource\MySQL\SearchAllUnitsOfMeasurement($this->container);

        return $measurementesList->read([]);
    }

    /**
     * Guarda una nueva unidad de medida si esta no existe.
     *
     * @param array $userInput Input con los datos necesarios para crear una nueva unidad de medida
     *
     * @return bool True si se logró crear; False de lo contrario
     */
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

    /**
     * Obtiene la ID de una unidad de medida según su nombre.
     *
     * @param string $name Nombre de la unidad de medida
     *
     * @return string La ID
     */
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
