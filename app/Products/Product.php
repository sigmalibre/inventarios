<?php

namespace Sigmalibre\Products;

class Product
{
    private $container;
    private $validator;
    private $attributes;

    private function init($id, $container)
    {
        $this->container = $container;
        $this->validator = new ProductValidator($container);

        $getProductFromID = new DataSource\MySQL\GetProductFromID($container);

        $this->attributes = $getProductFromID->read([
            'input' => [
                'idProducto' => $id,
            ],
        ]);
    }

    public function __construct($id, $container)
    {
        $this->init($id, $container);
    }

    public function isset()
    {
        return isset($this->attributes[0]);
    }

    public function __get($property)
    {
        if (isset($this->attributes[0][$property])) {
            return $this->attributes[0][$property];
        }
    }

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
            $this->init($this->ProductoID, $this->container);
        }

        return $isProductUpdated;
    }

    public function getInvalidInputs()
    {
        return $this->validator->getInvalidInputs();
    }
}
