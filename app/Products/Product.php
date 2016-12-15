<?php

namespace Sigmalibre\Products;

/**
 * Modelo para operaciones sobre los productos individuales.
 */
class Product
{
    private $container;
    private $validator;
    private $attributes;
    private $dataSource;

    /**
     * Inicializa el objeto obteniendo la información sobre si mismo desde la fuente de datos.
     *
     * Este método se separó del constructor ya que se necesita inicializar el producto denuevo
     * cuando se realiza una actualización y hay que refrescar los datos denuevo desde la fuente
     * de datos.
     *
     * @param string $id La ID del producto que se va a iniciar
     */
    private function init($id)
    {
        $this->attributes = $this->dataSource->read([
            'input' => [
                'idProducto' => $id,
            ],
        ]);
    }

    public function __construct($id, $container)
    {
        $this->container = $container;
        $this->validator = new ProductValidator($container);
        $this->dataSource = new DataSource\MySQL\GetProductFromID($container);

        $this->init($id);
    }

    /**
     * Comprueba si el objeto existe en la fuente de datos.
     *
     * @return bool True si se pudo obtener la información; False de lo contrario
     */
    public function isset()
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
     * Obtiene la lista con los inputs inválidos al actualizar el producto.
     * Se utiliza para dar mejor feedback al usuario.
     *
     * @return array Lista con todos los inputs que no pasaron la validación
     */
    public function getInvalidInputs()
    {
        return $this->validator->getInvalidInputs();
    }
}
