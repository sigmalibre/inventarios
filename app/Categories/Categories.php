<?php

namespace Sigmalibre\Categories;

/**
 * Modelo para operaciones CRUD sobre las categorías de producto.
 */
class Categories
{
    private $container;
    private $validator;

    public function __construct($container)
    {
        $this->container = $container;
        $this->validator = new CategoryValidator($container);
    }

    /**
     * Realiza una lectura de las categorías de producto existentes.
     *
     * @return array Lista con los datos obtenidos por la lectura, filtrados por términos de búsqueda y paginados
     */
    public function readCategoryList($userInput)
    {
        $listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllFilteredCategories($this->container),
            new DataSource\MySQL\FilterAllCategories($this->container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );

        $categoryList = $listReader->read();
        // Se regresa el input al usuario para ponerlo de nuevo en el formulario.
        $categoryList['userInput'] = $userInput;

        return $categoryList;
    }

    /**
     * Obtiene todas las categorías de productos sin filtros ni limitaciones.
     *
     * @return array
     */
    public function readAllCategories()
    {
        $categoryList = new DataSource\MySQL\SearchAllCategories($this->container);

        return $categoryList->read([]);
    }

    /**
     * Guarda una categoría nueva en la fuente de datos.
     *
     * @param array $userInput Lista con los inputs del usuario
     *
     * @return bool True si se ha guardado la categoría; False si no aprueba la validación, o si ocurrió un error
     */
    public function save($userInput)
    {
        // Limpiar los espacios en blanco al inicio y final de todos los inputs.
        $userInput = array_map('trim', $userInput);

        // Validar el input del usuario.
        if ($this->validator->validateNewCategory($userInput) === false) {
            return false;
        }

        // Cambiar el código de la categoría a mayúsculas
        $userInput['codigoCategoria'] = strtoupper($userInput['codigoCategoria']);

        // Guardar la categoría.
        $categoryWriter = new DataSource\MySQL\SaveNewCategory($this->container);

        return $categoryWriter->write($userInput);
    }

    /**
     * Método wrapper para obtener los inputs inválidos desde el validador.
     *
     * @return array La lista con los inputs inválidos
     */
    public function getInvalidInputs()
    {
        return $this->validator->getInvalidInputs();
    }

    /**
     * Obtiene la ID de una categoría a partir de su nombre.
     *
     * @param string $name Nombre de la categoría, sin distinción entre mayúsculas y minúsculas
     *
     * @return string La Id si fue encontrada, false de lo contrario
     */
    public function idFromName($name)
    {
        $itemList = $this->readAllCategories();

        // Revisar si ya existe la categoría, y obtener su ID.
        foreach ($itemList as $item) {
            if (strtolower($item['Nombre']) === strtolower($name)) {
                return $item['CategoriaProductoID'];
            }
        }

        return false;
    }
}
