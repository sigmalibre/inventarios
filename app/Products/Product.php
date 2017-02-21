<?php

namespace Sigmalibre\Products;

use Sigmalibre\Categories\CategoryValidator;
use Sigmalibre\Products\DataSource\MySQL\DeleteProducto;
use Sigmalibre\Products\DataSource\MySQL\GetProductFromID;
use Sigmalibre\Products\DataSource\MySQL\UpdateSingleAttributeProduct;

/**
 * Modelo para operaciones sobre los productos individuales.
 */
class Product
{
    protected $container;
    protected $validator;
    protected $categoryValidator;
    protected $attributes;

    public $Cantidad;
    public $CostoActual;
    public $CategoriaProductoID;
    public $CodigoProducto;
    public $Descripcion;
    public $StockMin;
    public $Utilidad;
    public $NombreMarca;
    public $UnidadMedida;
    public $CodigoBienDet;
    public $CodigoLibroDet;
    public $ExcentoIVA;
    public $ProductoID;
    public $Codigo;

    /**
     * Inicializa el objeto obteniendo la información sobre si mismo desde la fuente de datos.
     *
     * Este método se separó del constructor ya que se necesita inicializar el producto denuevo
     * cuando se realiza una actualización y hay que refrescar los datos denuevo desde la fuente
     * de datos.
     *
     * @param string $id La ID del producto que se va a iniciar
     */
    protected function init($id)
    {
        $data_source = new GetProductFromID($this->container);
        $this->attributes = $data_source->read([
            'input' => [
                'idProducto' => $id ?? -1,
            ],
        ]);

        $this->Cantidad = $this->attributes[0]['Cantidad'] ?? null;
        $this->CostoActual = $this->attributes[0]['CostoActual'] ?? null;
        $this->CategoriaProductoID = $this->attributes[0]['CategoriaProductoID'] ?? null;
        $this->CodigoProducto = $this->attributes[0]['CodigoProducto'] ?? null;
        $this->Descripcion = $this->attributes[0]['Descripcion'] ?? null;
        $this->StockMin = $this->attributes[0]['StockMin'] ?? null;
        $this->Utilidad = $this->attributes[0]['Utilidad'] ?? null;
        $this->NombreMarca = $this->attributes[0]['NombreMarca'] ?? null;
        $this->UnidadMedida = $this->attributes[0]['UnidadMedida'] ?? null;
        $this->CodigoBienDet = $this->attributes[0]['CodigoBienDet'] ?? null;
        $this->CodigoLibroDet = $this->attributes[0]['CodigoLibroDet'] ?? null;
        $this->ExcentoIVA = $this->attributes[0]['ExcentoIVA'] ?? null;
        $this->ProductoID = $this->attributes[0]['ProductoID'] ?? null;
        $this->Codigo = $this->attributes[0]['Codigo'] ?? null;
    }

    public function __construct($id, $container)
    {
        $this->container = $container;
        $this->validator = new ProductValidator();
        $this->categoryValidator = new CategoryValidator();

        $this->init($id);
    }

    /**
     * Comprueba si el objeto existe en la fuente de datos.
     *
     * @return bool True si se pudo obtener la información; False de lo contrario
     */
    public function is_set()
    {
        return isset($this->attributes[0]);
    }

    /**
     * Actualiza el objeto actual según los cambios realizados por el usuario.
     *
     * @param array  $userInput    Datos nuevos para actualizar
     * @param object $brands       Lista con todas las marcas, para crear una nueva si no existe
     * @param object $measurements Unidades de medida, para crear una nueva si no existe
     *
     * @return bool True si se logró actualizar; False de lo contrario
     */
    public function update($userInput, $brands, $measurements)
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

        // Si no se pudo obtener una marca.
        if ($brandId === false) {
            $this->validator->setInvalidInput('marcaProducto');
        }

        // Si la unidad de medida ya existe, utilizar esa.
        $unitId = $measurements->idFromName($userInput['medidaProducto']);

        // Si la unidad no existe, crear una nueva.
        if ($unitId === false) {
            $unitId = $measurements->save(['unidadMedida' => $userInput['medidaProducto']]);
        }

        // Si no se pudo obtener una unidad de medida.
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

        // Añadir la ID del producto actual al input del usuario.
        $userInput['id'] = $this->ProductoID;

        // Guardar el producto.
        $productsWriter = new DataSource\MySQL\UpdateProduct($this->container);

        $isProductUpdated = $productsWriter->write($userInput);

        if ($isProductUpdated === true) {
            $this->attributes = null;
            $this->init($this->ProductoID);
        }

        return $isProductUpdated;
    }

    /**
     * Actualiza la información sobre la utilidad de un producto.
     *
     * @param string $value El valor monetario de la utilidad
     *
     * @return bool
     */
    public function updateUtilidad($value)
    {
        // Limpiar los espacios en blanco al inicio y final del input.
        $value = trim($value);

        // Validar los inputs del usuario.
        if ($this->validator->validarUtilidad($value) === false) {
            return false;
        }

        $dataToUpdate = [
            'attribute' => 'Utilidad',
            'value' => $value,
            'id' => $this->ProductoID,
        ];


        $isUpdated = (new UpdateSingleAttributeProduct($this->container))->write($dataToUpdate);

        if ($isUpdated === true) {
            $this->attributes = null;
            $this->init($this->ProductoID);
        }

        return $isUpdated;
    }

    /**
     * Obtiene la lista con los inputs inválidos al actualizar el producto.
     * Se utiliza para dar mejor feedback al usuario.
     *
     * @return array Lista con todos los inputs que no pasaron la validación
     */
    public function getInvalidInputs()
    {
        return $this->validator->getInvalidInputs();
    }

    /**
     * Elimina este producto desde la fuente de datos.
     *
     * @return bool
     */
    public function delete()
    {
        $isDeleted = (new DeleteProducto($this->container))->write($this->ProductoID);

        $this->init($this->ProductoID);

        return $isDeleted;
    }
}
