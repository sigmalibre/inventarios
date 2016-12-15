<?php

namespace Sigmalibre\Categories;

/**
 * Controlador para las operaciones sobre las categorías de producto.
 */
class CategoriesController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Muestra una lista con las categorías de producto.
     *
     * @return array Lista con los datos sobre los productos y otra información necesaria
     */
    public function indexCategories($request, $response)
    {
        $categories = new Categories($this->container);
        $categoryResults = $categories->readCategoryList($request->getQueryParams());

        return $this->container->view->render($response, 'categories/categories.html', [
            'categories' => $categoryResults['itemList'],
            'pagination' => $categoryResults['pagination'],
            'input' => $categoryResults['userInput'],
        ]);
    }

    /**
     * Responde con la vista del formulario de creación de una nueva categoría.
     *
     * @param object $request       HTTP Request
     * @param object $response      HTTP Response
     * @param array  $arguments     La provee el framework, no se utiliza en este método
     * @param bool   $categorySaved Se utiliza para dar feedback al usuario sobre si se creó una nueva categoría o no
     * @param array  $failedInputs  Contiene todos los inputs del usuario que no pasaron la validación
     *
     * @return object HTTP Request con la vista del formulario de nueva categoría
     */
    public function indexNewCategory($request, $response, $arguments, $categorySaved = null, $failedInputs = null)
    {
        return $this->container->view->render($response, 'categories/newcategory.html', [
            'categorySaved' => $categorySaved,
            'failedInputs' => $failedInputs,
            'input' => $request->getParsedBody(),
        ]);
    }

    /**
     * Renderiza la vista del formulario de modificación de categorías.
     *
     * @param object $request       HTTP Request
     * @param object $response      HTTP Response
     * @param array  $arguments     Contiene la ID de la categoría que fue modificada
     * @param bool   $categorySaved Su función es dar feedback al usuario sobre si se pudo modificar la categoría o no
     * @param array  $failedInputs  Si no se pudo modificar, este contiene la lista con los inputs que no pasaron la validación
     *
     * @return object HTTP Response con la vista renderizada
     */
    public function indexCategory($request, $response, $arguments, $categorySaved = null, $failedInputs = null)
    {
        $category = new Category($arguments['id'], $this->container);

        // Si la categoría especificada en la URL no existe, devolver un 404.
        if ($category->isset() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        return $this->container->view->render($response, 'categories/modifycategory.html', [
            'categorySaved' => $categorySaved,
            'failedInputs' => $failedInputs,
            'input' => [
                'codigoCategoria' => $category->CategoriaProductoID,
                'nombreCategoria' => $category->Nombre,
            ],
        ]);
    }

    /**
     * Recibe el input del usuario para crear una nueva categoría.
     *
     * @param object $request  HTTP Request
     * @param object $response HTTP Response
     *
     * @return object HTTP Request con la vista del formulario de nueva categoría
     */
    public function createNew($request, $response)
    {
        $categories = new Categories($this->container);

        $isCategorySaved = $categories->save($request->getParsedBody());

        return $this->indexNewCategory($request, $response, null, $isCategorySaved, $categories->getInvalidInputs());
    }

    /**
     * Actualiza la información sobre una categoría.
     *
     * @param object $request   HTTP Request
     * @param object $response  HTTP Response
     * @param array  $arguments Contiene la ID de la categoría que será modificada
     *
     * @return object HTTP Response con la vista del formulario de modificar categoría
     */
    public function update($request, $response, $arguments)
    {
        $category = new Category($arguments['id'], $this->container);

        // Si la categoría especificada en la URL no existe, devolver un 404.
        if ($category->isset() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        $userInput = $request->getParsedBody();

        $isCategoryUpdated = $category->update($userInput);

        $arguments['id'] = $userInput['codigoCategoria'];

        return $this->indexCategory($request, $response, $arguments, $isCategoryUpdated, $category->getInvalidInputs());
    }
}
