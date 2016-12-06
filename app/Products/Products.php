<?php

namespace Sigmalibre\Products;

/**
 * Realiza operaciones CRUD sobre los productos.
 */
class Products
{
    private $container;
    private $validator;

    public function __construct($container)
    {
        $this->container = $container;
        $this->validator = new ProductValidator($container);
    }

    /**
     * Lee la lista de todos los productos, sin filtrar resultados, con capacidad de paginación.
     *
     * @return array Lista de los productos
     */
    public function readProductList($userInput)
    {
        if (empty($userInput['codigoProducto']) === false) {
            $codigoProducto = $userInput['codigoProducto'];

            $userInput['claveProducto'] = (string) substr($codigoProducto, 2);
            $userInput['codigoCategoria'] = (string) substr($codigoProducto, 0, 2);
        }

        $listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllFilteredProducts($this->container),
            new DataSource\MySQL\FilterAllProducts($this->container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );

        $productList = $listReader->read();
        $productList['userInput'] = $userInput;

        return $productList;
    }

    /**
     * Guarda un producto nuevo en la fuente de datos.
     *
     * @param array $userInput    Lista con los inputs del usuario
     * @param array $brands       Lista de las marcas de productos, para buscar si existe la que ingresó el usuario y crearla sino
     * @param array $measurements Lista de unidades de medidad, para buscar si existe la que ingresó el usuario y crearla sino
     *
     * @return bool True si se ha guardado el producto; False si no aprueba la validación o si ha ocurrido un error
     */
    public function save($userInput, $brands, $measurements)
    {
        // Limpiar los espacios en blanco al inicio y final de todos los inputs.
        $userInput = array_map('trim', $userInput);

        // Ya que el campo de excentoIvaProducto es opcional, si no se pasa un valor, dejar 0 por defecto.
        if (empty($userInput['excentoIvaProducto']) === true) {
            $userInput['excentoIvaProducto'] = 0;
        }

        // Validar los inputs del usuario.
        if ($this->validator->validateNewProduct($userInput) === false) {
            return false;
        }

        // Si la marca ingresada ya existe, utilizar esa.
        $brandId = $brands->idFromName($userInput['marcaProducto']);

        // Si la marca no existe, crear una nueva.
        if ($brandId === false) {
            $brandId = $brands->save(['nombreMarca' => $userInput['marcaProducto']]);
        }

        // Si no se pudo obtener una marca, retorna false.
        if ($brandId === false) {
            $this->validator->setInvalidInput('marcaProducto');

            return false;
        }

        // Si la unidad de medida ya existe, utilizar esa.
        $unitId = $measurements->idFromName($userInput['medidaProducto']);

        // Si la unidad no existe, crear una nueva.
        if ($unitId === false) {
            $unitId = $measurements->save(['unidadMedida' => $userInput['medidaProducto']]);
        }

        // Si no se pudo obtener una unidad de medida, retorna false.
        if ($unitId === false) {
            $this->validator->setInvalidInput('medidaProducto');

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
}
