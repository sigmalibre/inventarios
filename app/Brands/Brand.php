<?php

namespace Sigmalibre\Brands;

class Brand
{
    private $container;
    private $validator;
    private $attributes;
    private $dataSource;

    /**
     * Inicializa el objeto obteniendo la información sobre si mismo desde la fuente de datos.
     *
     * Este método se separó del constructor ya que se necesita inicializar el producto denuevo
     * cuando se realiza una actualización y hay que refrescar los datos de nuevo desde la fuente de datos.
     *
     * @param string $id La ID de la marca
     */
    public function init($id)
    {
        $this->attributes = $this->dataSource->read([
            'input' => [
                'idMarca' => $id,
            ],
        ]);
    }

    public function __construct($id, $container)
    {
        $this->container = $container;
        $this->validator = new BrandValidator();
        $this->dataSource = new DataSource\MySQL\GetBrandFromID($container);

        $this->init($id);
    }

    /**
     * Comprueba si el bojeto existe en la fuente de datos.
     *
     * @return bool True si se pudo obtener la información; False de lo contrario
     */
    public function is_set()
    {
        return isset($this->attributes[0]);
    }

    /**
     * Se utiliza el método mágico __get para obtener de forma flexible los atributos
     * desde la fuente de datos sin ponerlos escritos directamente dentro de éste código.
     *
     * @param array $property La propiedad que se desea obtener
     *
     * @return string El atributo si existe
     */
    public function __get($property)
    {
        if (isset($this->attributes[0][$property])) {
            return $this->attributes[0][$property];
        }
    }

    /**
     * Actualiza el objeto actual según los cambios realizados por el usuario.
     *
     * @param array $userInput Datos nuevos por actualizar
     *
     * @return bool True si se logró actualizar; False de lo contrario
     */
    public function update($userInput)
    {
        // Limpiar los espacios en blanco al inicio y final de todos los inputs.
        $userInput = array_map('trim', $userInput);

        // Validar el input del usuario.
        if ($this->validator->validate($userInput) === false) {
            return false;
        }

        // Añadir la ID de la marca actual al input del usuario.
        $userInput['id'] = $this->MarcaID;

        // Guardar los cambios.
        $brandWriter = new DataSource\MySQL\UpdateBrand($this->container);

        $isBrandUpdated = $brandWriter->write($userInput);

        if ($isBrandUpdated === true) {
            $this->attributes = null;
            $this->init($this->MarcaID);
        }

        return $isBrandUpdated;
    }

    /**
     * Obtiene la lista con los inputs inválidos al actualizar la marca.
     * Se utiliza para dar mejor feedback al usuario.
     *
     * @return array Lista con todos los inputs que no pasaron la validación
     */
    public function getInvalidInputs()
    {
        return $this->validator->getInvalidInputs();
    }
}
