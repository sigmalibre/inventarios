<?php

namespace Sigmalibre\Categories;

use Sigmalibre\Categories\DataSource\MySQL\DeleteCategory;

/**
 * Modelo para operaciones sobre las categorías individuales.
 */
class Category
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
     * @param string $id La ID de la categoría
     */
    public function init($id)
    {
        $this->attributes = $this->dataSource->read([
            'input' => [
                'codigoCategoria' => empty($id) ? -1 : $id,
            ],
        ]);
    }

    public function __construct($id, $container)
    {
        $this->container = $container;
        $this->validator = new CategoryValidator();
        $this->dataSource = new DataSource\MySQL\GetCategoryFromID($container);

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

        // Cambiar el código de la categoría a mayúsculas
        $userInput['codigoCategoria'] = strtoupper($userInput['codigoCategoria']);

        // Añadir la ID del producto actual al input del usuario.
        $userInput['id'] = $this->CategoriaProductoID;

        // Guardar la categoría.
        $categoryWriter = new DataSource\MySQL\UpdateCategory($this->container);

        $isCategoryUpdated = $categoryWriter->write($userInput);

        if ($isCategoryUpdated === true) {
            $this->attributes = null;
            $this->init($userInput['codigoCategoria']);
        }

        return $isCategoryUpdated;
    }

    /**
     * Obtiene la lista con los inputs inválidos al actualizar la categoría.
     * Se utiliza para dar mejor feedback al usuario.
     *
     * @return array Lista con todos los inputs que no pasaron la validación
     */
    public function getInvalidInputs()
    {
        return $this->validator->getInvalidInputs();
    }

    public function delete()
    {
        return (new DeleteCategory($this->container))->write($this->CategoriaProductoID);
    }
}
