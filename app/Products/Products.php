<?php

namespace Sigmalibre\Products;

use Sigmalibre\Brands\Brand;
use Sigmalibre\Brands\Brands;
use Sigmalibre\Categories\Category;
use Sigmalibre\Categories\CategoryValidator;
use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\Pagination\Paginator;
use Sigmalibre\Products\DataSource\MySQL\DeleteFromBrand;
use Sigmalibre\Products\DataSource\MySQL\DeleteFromCategory;
use Sigmalibre\Products\DataSource\MySQL\DeleteFromMedida;
use Sigmalibre\Products\DataSource\MySQL\SearchAllProducts;
use Sigmalibre\Products\DataSource\MySQL\UpdateBrand;
use Sigmalibre\Products\DataSource\MySQL\UpdateCategory;
use Sigmalibre\Products\DataSource\MySQL\UpdateMedida;
use Sigmalibre\UnitsOfMeasurement\Unit;
use Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurement;

/**
 * Realiza operaciones CRUD sobre los productos.
 */
class Products
{
    private $container;
    private $validator;
    private $categoryValidator;

    public function __construct($container)
    {
        $this->container = $container;
        $this->validator = new ProductValidator();
        $this->categoryValidator = new CategoryValidator();
    }

    /**
     * Lee la lista de todos los productos, con filtros según terminos de búsqueda, con capacidad de paginación.
     *
     * @param $userInput
     *
     * @return array Lista de los productos
     */
    public function readProductList($userInput)
    {
        if (isset($userInput['productoActivo']) === false) {
            $userInput['productoActivo'] = '1';
        }

        if (isset($userInput['orderby']) === false) {
            $userInput['orderby'] = 'CodigoProducto';
        }

        $listReader = new ItemListReader(
            new DataSource\MySQL\CountAllFilteredProducts($this->container),
            new DataSource\MySQL\FilterAllProducts($this->container),
            new Paginator($userInput),
            $userInput
        );

        $productList = $listReader->read();
        $productList['userInput'] = $userInput;

        return $productList;
    }

    public function readAllProudcts($input = [])
    {
        $buscadorProductos = new SearchAllProducts($this->container);

        $options = [
            'input' => [
                'productoActivo' => '1'
            ]
        ];

        $options['input'] = array_merge($options['input'], $input);

        $listaProductos = $buscadorProductos->read($options);

        $listaProductos = array_filter($listaProductos, function ($p) {
            return $p['Cantidad'] > 0 && $p['CostoActual'] > 0;
        });

        return $listaProductos;
    }

        public function readAllProudctsUnfiltered($input = [])
    {
        $buscadorProductos = new SearchAllProducts($this->container);

        $options = [
            'input' => [
                'productoActivo' => '1'
            ]
        ];

        $options['input'] = array_merge($options['input'], $input);

        $listaProductos = $buscadorProductos->read($options);

        return $listaProductos;
    }


    /**
     * Guarda un producto nuevo en la fuente de datos.
     *
     * @param array                                             $userInput    Lista con los inputs del usuario
     * @param \Sigmalibre\Brands\Brands                         $brands       Lista de las marcas de productos, para buscar si existe la que ingresó el usuario y crearla sino
     * @param \Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurement $measurements Lista de unidades de medidad, para buscar si existe la que ingresó el usuario y crearla sino
     *
     * @return bool True si se ha guardado el producto; False si no aprueba la validación o si ha ocurrido un error
     */
    public function save($userInput, Brands $brands, UnitsOfMeasurement $measurements)
    {
        // Limpiar los espacios en blanco al inicio y final de todos los inputs.
        $userInput = array_map('trim', $userInput);

        // Ya que el campo de excentoIvaProducto es opcional, si no se pasa un valor, dejar 0 por defecto.
        if (empty($userInput['excentoIvaProducto']) === true) {
            $userInput['excentoIvaProducto'] = 0;
        }

        // El campo de utilidadProducto es opcional, por defecto será 0.
        if (empty($userInput['utilidadProducto']) === true) {
            $userInput['utilidadProducto'] = 0;
        }

        // Validar los inputs del usuario.
        $this->validator->validate($userInput);

        // Validar código de la categoríá.
        if ($this->categoryValidator->validarCodigo(['codigoCategoria' => $userInput['categoriaProducto']]) === false) {
            $this->validator->setInvalidInput('codigoCategoria');
        }

        // Si la marca ingresada ya existe, utilizar esa.
        $brandId = $brands->idFromName($userInput['marcaProducto']);

        // Si la marca no existe, crear una nueva.
        if ($brandId === false) {
            $brandId = $brands->save(['nombreMarca' => $userInput['marcaProducto']]);
        }

        // Si no se pudo obtener una marca
        if ($brandId === false) {
            $this->validator->setInvalidInput('marcaProducto');
        }

        // Si la unidad de medida ya existe, utilizar esa.
        $unitId = $measurements->idFromName($userInput['medidaProducto']);

        // Si la unidad no existe, crear una nueva.
        if ($unitId === false) {
            $unitId = $measurements->save(['unidadMedida' => $userInput['medidaProducto']]);
        }

        // Si no se pudo obtener una unidad de medida
        if ($unitId === false) {
            $this->validator->setInvalidInput('medidaProducto');
        }

        // Si los validadores no aprovaron.
        if (empty($this->validator->getInvalidInputs()) === false) {
            return false;
        }

        // Si se pudo obtener una marca, reemplazar su nombre por su id para hacer la inserción.
        $userInput['marcaProducto'] = $brandId;

        // Si se pudo obtener una medida, reemplazar su nombre por su id para hacer l ainserción.
        $userInput['medidaProducto'] = $unitId;

        // Guardar el producto.
        $productsWriter = new DataSource\MySQL\SaveNewProduct($this->container);

        // return true;
        return $productsWriter->write($userInput);
    }

    /**
     * Obtiene una lista de los inputs inválidos si una operación de guardado ha fallado.
     *
     * @return array La lista con los inputs inválidos
     */
    public function getInvalidInputs()
    {
        return $this->validator->getInvalidInputs();
    }

    public function replaceBrand(Brand $toReplace, Brand $replacement)
    {
        if ($toReplace->is_set() !== true && $replacement->is_set() !== true) {
            return false;
        }

        return (new UpdateBrand($this->container))->write($toReplace->MarcaID, $replacement->MarcaID);
    }

    public function deleteFromBrand(Brand $toDelete)
    {
        if ($toDelete->is_set() === false) {
            return false;
        }

        return (new DeleteFromBrand($this->container))->write($toDelete->MarcaID);
    }

    public function replaceCategory(Category $toReplace, Category $replacement)
    {
        if ($toReplace->is_set() !== true && $replacement->is_set() !== true) {
            return false;
        }

        return (new UpdateCategory($this->container))->write($toReplace->CategoriaProductoID, $replacement->CategoriaProductoID);
    }

    public function deleteFromCategory(Category $toDelete)
    {
        if ($toDelete->is_set() === false) {
            return false;
        }

        return (new DeleteFromCategory($this->container))->write($toDelete->CategoriaProductoID);
    }

    public function replaceMedida(Unit $toReplace, Unit $replacement)
    {
        if ($toReplace->is_set() !== true && $replacement->is_set() !== true) {
            return false;
        }

        return (new UpdateMedida($this->container))->write($toReplace->MedidaID, $replacement->MedidaID);
    }

    public function deleteFromMedida(Unit $toDelete)
    {
        if ($toDelete->is_set() === false) {
            return false;
        }

        return (new DeleteFromMedida($this->container))->write($toDelete->MedidaID);
    }
}
