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

    public function indexNewCategory($request, $response, $arguments, $categorySaved = null, $failedInputs = null)
    {
        return $this->container->view->render($response, 'categories/newcategory.html', [
            'categorySaved' => $categorySaved,
            'failedInputs' => $failedInputs,
            'input' => $request->getParsedBody(),
        ]);
    }

    public function createNew($request, $response)
    {
        $categories = new Categories($this->container);

        $isCategorySaved = $categories->save($request->getParsedBody());

        $this->indexNewCategory($request, $response, null, $isCategorySaved, $categories->getInvalidInputs());
    }
}
