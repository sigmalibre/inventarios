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
        $parameters = $request->getQueryParams();

        $categories = new Categories($this->container, $parameters);
        $categoryResults = $categories->readCategoryList();

        return $this->container->view->render($response, 'categories.html', [
            'categories' => $categoryResults['categoryList'],
            'pagination' => $categoryResults['pagination'],
            'input' => $categoryResults['userInput'],
        ]);
    }
}
