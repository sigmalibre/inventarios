<?php

namespace Sigmalibre\UnitsOfMeasurement;

/**
 * Modelo para las operaciones sobre las unidades de medida.
 */
class UnitsOfMeasurement
{
    private $container;
    private $validator;

    public function __construct($container)
    {
        $this->container = $container;
        $this->validator = new UnitValidator();
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
        // Validar el input del usuario
        if ($this->validator->validate($userInput) === false) {
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

    /**
     * Obtiene la lista con los inputs inválidos al crear la unidad de medida.
     * Se utiliza para dar mejor feedback al usuario.
     *
     * @return array Lista con todos los inputs que no pasaron la validación
     */
    public function getInvalidInputs()
    {
        return $this->validator->getInvalidInputs();
    }
}
