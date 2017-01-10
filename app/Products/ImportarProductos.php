<?php

namespace Sigmalibre\Products;

use Sigmalibre\Ingresos\IngresosSoftValidator;

/**
 * Realiza una importación de los datos provenientes desde la BD que utiliza
 * el programa PowerAcc, el cual utiliza la empresa para la cual fue diseñado
 * originalmente este proyecto, Esto es con el fin de ahorrarles el trabajo de
 * tener que ingresar uno por uno los miles de productos con los que su antiguo
 * sistema ya estaba trabajando.
 */
class ImportarProductos
{
    private $container;
    private $categoriasCreadas = 0;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Obtiene la información sobre productos que serán importados.
     *
     * @return array
     */
    private function obtenerProductosAImportar()
    {
        $listaProductosAImportar = new DataSource\MySQL\ObtenerProductosAImportar($this->container, new \Sigmalibre\DataSource\MySQL\MySQLCustomDatabase('trasladoinventario'));

        return $listaProductosAImportar->read([]);
    }

    /**
     * Obtiene información adicional a la que se obtiene mediante obtenerProductosAImportar
     * y que es necesaria para la correcta creación de productos nuevos.
     *
     * @return array
     */
    private function obtenerDatosAdicionalesAImportar()
    {
        $listaDatosAdicionales = new DataSource\MySQL\DatosAdicionalesProductosAImportar($this->container, new \Sigmalibre\DataSource\MySQL\MySQLCustomDatabase('inventarios'));

        return $listaDatosAdicionales->read([]);
    }

    /**
     * La información vieja le hacen falta datos necesarios para poder
     * trasladarla a la BD nueva, esa información se obtiene desde la BD antigua
     * y se añade a la información corregida.
     *
     * @return array
     */
    private function prepararDatosAImportar()
    {
        $listaDatosAImportar = $this->obtenerProductosAImportar();

        $listaDatosAdicionales = $this->obtenerDatosAdicionalesAImportar();

        // Convierte la lista con los datos adicionales de utilizar índice
        // numérico a ser una lista asociativa utilizando el código del producto
        // como el índice de la lista.
        $datosAdicionalesAsociativa = [];

        foreach ($listaDatosAdicionales as $dato) {
            $datosAdicionalesAsociativa[$dato['codigo_mas']] = $dato;
        }

        // Une la lista con los datos a importar junto con la lista de los datos
        // adicionales para crear una sola con ambos datos necesarios para
        // completar la creación de un producto.
        $listaDatosCompletos = array_map(function ($datoAImportar) use ($datosAdicionalesAsociativa) {
            $datoAImportar['Utilidad'] = $datosAdicionalesAsociativa[$datoAImportar['Codigo']]['precio1_cst'] ?? 0;
            $datoAImportar['CodiboBienDet'] = $datosAdicionalesAsociativa[$datoAImportar['Codigo']]['codigo_catbiendet'] ?? '01';
            $datoAImportar['ReferenciaLibroDet'] = $datosAdicionalesAsociativa[$datoAImportar['Codigo']]['codigo_reflibrodet'] ?? '03';

            return $datoAImportar;
        },
        $listaDatosAImportar);

        return $listaDatosCompletos;
    }

    /**
     * Para realizar el importe, se deben crear las categorías si estas no
     * existen.
     *
     * @param string $nombre Nombre de la categoría
     *
     * @return string Cógigo de la categoría creada
     */
    private function crearCategoria($nombre)
    {
        $buscadorCategorias = new \Sigmalibre\Categories\Categories($this->container);

        // Si la categoría ingresada ya existe, utilizar esa.
        $idCategoria = $buscadorCategorias->idFromName($nombre);

        // Si la categoría no existe, crear una nueva.
        if ($idCategoria === false) {
            $idCategoria = $buscadorCategorias->save([
                'codigoCategoria' => sprintf('%02d', $this->categoriasCreadas++),
                'nombreCategoria' => $nombre,
            ]);
        }

        // Si no se pudo obtener la categoría, retorna false.
        return $idCategoria;
    }

    /**
     * Realiza una lectura desde la fuente de datos para obtener la lista
     * con los datos de los productos que desean ser creados por lotes y los
     * ingresa en la BD del sistema.
     *
     * @return bool True si se pudo realizar la importación, false de lo contrario
     *
     * @throws \RuntimeException Si la categoría no pudo ser creada
     */
    public function importar()
    {
        $productosPorCrear = $this->prepararDatosAImportar();

        $creadorProductos = new \Sigmalibre\Products\Products($this->container);
        $marcas = new \Sigmalibre\Brands\Brands($this->container);
        $medidas = new \Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurement($this->container);
        $ingresos = new \Sigmalibre\Ingresos\Ingresos($this->container, new IngresosSoftValidator());

        $this->container->mysql->beginTransaction();

        foreach ($productosPorCrear as $index => $producto) {
            $categoriaCreada = $this->crearCategoria($producto['Categoria']);

            // Revisar si la categoría no pudo ser creada
            if ($categoriaCreada === false) {
                $this->container->mysql->rollBack();

                // Detener la importación.
                throw new \RuntimeException('La categoría "'.$producto['Categoria'].'" no pudo ser creada.');
            }

            // Revisar si el producto ya existe.
            $productoExistente = new ProductFromCode($producto['Codigo'], $this->container);

            // Si el producto no existe.
            if ($productoExistente->is_set() === false) {
                $seCreoProducto = $creadorProductos->save([
                    'codigoProducto' => $producto['Codigo'],
                    'descripcionProducto' => $producto['Descripcion'],
                    'stockMinProducto' => 1,
                    'utilidadProducto' => $producto['Utilidad'],
                    'referenciaLibroDetProducto' => $producto['ReferenciaLibroDet'],
                    'categoriaDetProducto' => $producto['CodiboBienDet'],
                    'marcaProducto' => $producto['Marca'],
                    'medidaProducto' => $producto['Medida'],
                    'categoriaProducto' => $categoriaCreada,
                ], $marcas, $medidas);

                // Revisar si el producto no fue creado.
                if ($seCreoProducto === false) {
                    $this->container->mysql->rollBack();

                    // Detener la importación.
                    throw new \RuntimeException('El producto ['.$producto['Codigo'].'] no pudo ser creado.');
                }

                // El producto se creó.
                // Guardar costoInicial.
                $isIngresoSaved = $ingresos->save([
                    'cantidadIngreso' => $producto['Unidades'],
                    'valorPrecioUnitario' => $producto['Costo'],
                    'valorCostoActualTotal' => $producto['Costo'], // El costo inicial es igual al unitario.
                    'empresaID' => null,
                    'almacenID' => 1, // Por defecto se elige el primer almacén que exista, si no existe la importación falla.
                ], $seCreoProducto);

                if ($isIngresoSaved === false) {
                    $this->container->mysql->rollBack();

                    // Detener la importación.
                    throw new \RuntimeException('No se pudo establecer el costo inicial del producto ['.$producto['Codigo'].']');
                }
            }
        }

        // LLegados a este punto, significa que no hubo ningún error en la
        // importación de los productos, es seguro realizar un commit.
        $this->container->mysql->commit();

        return true;
    }
}
