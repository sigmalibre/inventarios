-- MySQL dump 10.15  Distrib 10.0.27-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: inventario
-- ------------------------------------------------------
-- Server version	10.0.27-MariaDB-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Almacenes`
--

DROP TABLE IF EXISTS `Almacenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Almacenes` (
  `AlmacenID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NombreAlmacen` varchar(50) NOT NULL,
  PRIMARY KEY (`AlmacenID`),
  UNIQUE KEY `NombreAlmacen_UNIQUE` (`NombreAlmacen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CategoriaProductos`
--

DROP TABLE IF EXISTS `CategoriaProductos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CategoriaProductos` (
  `CategoriaProductoID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Codigo` varchar(2) NOT NULL,
  PRIMARY KEY (`CategoriaProductoID`),
  UNIQUE KEY `Nombre_UNIQUE` (`Nombre`),
  UNIQUE KEY `Codigo_UNIQUE` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CategoriasBienDet`
--

DROP TABLE IF EXISTS `CategoriasBienDet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CategoriasBienDet` (
  `CodigoBienDet` varchar(2) NOT NULL,
  `Descripcion` varchar(40) NOT NULL,
  PRIMARY KEY (`CodigoBienDet`),
  UNIQUE KEY `Categorias_UNIQUE` (`Descripcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Clientes`
--

DROP TABLE IF EXISTS `Clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Clientes` (
  `ClienteID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmpresaID` int(10) unsigned DEFAULT NULL,
  `PersonaID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ClienteID`),
  UNIQUE KEY `EmpresaID_UNIQUE` (`EmpresaID`),
  UNIQUE KEY `PersonaID_UNIQUE` (`PersonaID`),
  KEY `fk_Clientes_Empresas1_idx` (`EmpresaID`),
  KEY `fk_Clientes_PersonaCliente1_idx` (`PersonaID`),
  CONSTRAINT `fk_Clientes_Empresas1` FOREIGN KEY (`EmpresaID`) REFERENCES `Empresas` (`EmpresaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Clientes_PersonaCliente1` FOREIGN KEY (`PersonaID`) REFERENCES `PersonaCliente` (`PersonaID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DUIs`
--

DROP TABLE IF EXISTS `DUIs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DUIs` (
  `DuiID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NumeroDUI` varchar(15) NOT NULL,
  `PersonaID` int(10) unsigned DEFAULT NULL,
  `EmpleadoID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`DuiID`),
  KEY `fk_DUIs_PersonaCliente1_idx` (`PersonaID`),
  KEY `fk_DUIs_Empleados1_idx` (`EmpleadoID`),
  CONSTRAINT `fk_DUIs_Empleados1` FOREIGN KEY (`EmpleadoID`) REFERENCES `Empleados` (`EmpleadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_DUIs_PersonaCliente1` FOREIGN KEY (`PersonaID`) REFERENCES `PersonaCliente` (`PersonaID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DetalleAlmacenes`
--

DROP TABLE IF EXISTS `DetalleAlmacenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DetalleAlmacenes` (
  `DetalleAlmacenesID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Cantidad` int(11) NOT NULL,
  `AlmacenID` int(10) unsigned NOT NULL,
  `ProductoID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`DetalleAlmacenesID`),
  KEY `fk_DetalleAlmacenes_Almacenes1_idx` (`AlmacenID`),
  KEY `fk_DetalleAlmacenes_Productos1_idx` (`ProductoID`),
  CONSTRAINT `fk_DetalleAlmacenes_Almacenes1` FOREIGN KEY (`AlmacenID`) REFERENCES `Almacenes` (`AlmacenID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_DetalleAlmacenes_Productos1` FOREIGN KEY (`ProductoID`) REFERENCES `Productos` (`ProductoID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DetalleFactura`
--

DROP TABLE IF EXISTS `DetalleFactura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DetalleFactura` (
  `DetalleFacutaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Cantidad` int(11) NOT NULL,
  `PrecioUnitario` decimal(19,4) NOT NULL,
  `VentaExcenta` decimal(19,4) NOT NULL,
  `VentaAfecta` decimal(19,4) NOT NULL,
  `ProductoID` int(10) unsigned DEFAULT NULL,
  `FacturaID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`DetalleFacutaID`),
  KEY `fk_DetalleMovimientos_Productos1_idx` (`ProductoID`),
  KEY `fk_DetalleMovimientos_Facturas1_idx` (`FacturaID`),
  CONSTRAINT `fk_DetalleMovimientos_Facturas1` FOREIGN KEY (`FacturaID`) REFERENCES `Facturas` (`FacturaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_DetalleMovimientos_Productos1` FOREIGN KEY (`ProductoID`) REFERENCES `Productos` (`ProductoID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DetalleIngresos`
--

DROP TABLE IF EXISTS `DetalleIngresos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DetalleIngresos` (
  `DetalleIngresosID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Cantidad` int(11) NOT NULL,
  `PrecioUnitario` decimal(19,4) NOT NULL,
  `FechaIngreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ProductoID` int(10) unsigned NOT NULL,
  `EmpresaID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`DetalleIngresosID`),
  KEY `fk_DetalleIngresos_Productos1_idx` (`ProductoID`),
  KEY `fk_DetalleIngresos_Empresas1_idx` (`EmpresaID`),
  CONSTRAINT `fk_DetalleIngresos_Empresas1` FOREIGN KEY (`EmpresaID`) REFERENCES `Empresas` (`EmpresaID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_DetalleIngresos_Productos1` FOREIGN KEY (`ProductoID`) REFERENCES `Productos` (`ProductoID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Direcciones`
--

DROP TABLE IF EXISTS `Direcciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Direcciones` (
  `DireccionID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Pais` varchar(150) NOT NULL,
  `Departamento` varchar(45) NOT NULL,
  `Municipio` varchar(45) NOT NULL,
  `Direccion` varchar(45) NOT NULL,
  `EmpresaID` int(10) unsigned DEFAULT NULL,
  `PersonaID` int(10) unsigned DEFAULT NULL,
  `EmpleadoID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`DireccionID`),
  KEY `fk_Direcciones_Empresas1_idx` (`EmpresaID`),
  KEY `fk_Direcciones_PersonaCliente1_idx` (`PersonaID`),
  KEY `fk_Direcciones_Empleados1_idx` (`EmpleadoID`),
  CONSTRAINT `fk_Direcciones_Empleados1` FOREIGN KEY (`EmpleadoID`) REFERENCES `Empleados` (`EmpleadoID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Direcciones_Empresas1` FOREIGN KEY (`EmpresaID`) REFERENCES `Empresas` (`EmpresaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Direcciones_PersonaCliente1` FOREIGN KEY (`PersonaID`) REFERENCES `PersonaCliente` (`PersonaID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Emails`
--

DROP TABLE IF EXISTS `Emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Emails` (
  `EmailID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Email` varchar(45) NOT NULL,
  `EmpresaID` int(10) unsigned DEFAULT NULL,
  `EmpleadoID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`EmailID`),
  KEY `fk_Emails_Empresas1_idx` (`EmpresaID`),
  KEY `fk_Emails_Empleados1_idx` (`EmpleadoID`),
  CONSTRAINT `fk_Emails_Empleados1` FOREIGN KEY (`EmpleadoID`) REFERENCES `Empleados` (`EmpleadoID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Emails_Empresas1` FOREIGN KEY (`EmpresaID`) REFERENCES `Empresas` (`EmpresaID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Empleados`
--

DROP TABLE IF EXISTS `Empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Empleados` (
  `EmpleadoID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombres` varchar(255) NOT NULL,
  `Apellidos` varchar(255) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `NUP` varchar(25) DEFAULT NULL,
  `ISSS` varchar(15) DEFAULT NULL,
  `FechaNacimiento` date DEFAULT NULL,
  `Codigo` varchar(5) NOT NULL,
  PRIMARY KEY (`EmpleadoID`),
  UNIQUE KEY `NUP_UNIQUE` (`NUP`),
  UNIQUE KEY `ISSS_UNIQUE` (`ISSS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Empresas`
--

DROP TABLE IF EXISTS `Empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Empresas` (
  `EmpresaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NombreComercial` varchar(100) NOT NULL,
  `RazonSocial` varchar(50) DEFAULT NULL,
  `Giro` varchar(255) DEFAULT NULL,
  `Registro` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`EmpresaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Facturas`
--

DROP TABLE IF EXISTS `Facturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Facturas` (
  `FacturaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FechaFacturacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Correlativo` int(11) NOT NULL,
  `TipoFacturaID` int(10) unsigned NOT NULL,
  `ClienteID` int(10) unsigned DEFAULT NULL,
  `EmpleadoID` int(10) unsigned DEFAULT NULL,
  `TirajeFacturaID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`FacturaID`),
  KEY `fk_Facturas_TiposFactura1_idx` (`TipoFacturaID`),
  KEY `fk_Facturas_Clientes1_idx` (`ClienteID`),
  KEY `fk_Facturas_Empleados1_idx` (`EmpleadoID`),
  KEY `fk_Facturas_TirajeFacturas1_idx` (`TirajeFacturaID`),
  CONSTRAINT `fk_Facturas_Clientes1` FOREIGN KEY (`ClienteID`) REFERENCES `Clientes` (`ClienteID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_Facturas_Empleados1` FOREIGN KEY (`EmpleadoID`) REFERENCES `Empleados` (`EmpleadoID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_Facturas_TiposFactura1` FOREIGN KEY (`TipoFacturaID`) REFERENCES `TiposFactura` (`TipoFacturaID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_Facturas_TirajeFacturas1` FOREIGN KEY (`TirajeFacturaID`) REFERENCES `TirajeFacturas` (`TirajeFacturaID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Marcas`
--

DROP TABLE IF EXISTS `Marcas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Marcas` (
  `MarcaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`MarcaID`),
  UNIQUE KEY `Nombre_UNIQUE` (`Nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Medidas`
--

DROP TABLE IF EXISTS `Medidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Medidas` (
  `MedidaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UnidadMedida` varchar(100) NOT NULL,
  PRIMARY KEY (`MedidaID`),
  UNIQUE KEY `UnidadMedida_UNIQUE` (`UnidadMedida`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `NITs`
--

DROP TABLE IF EXISTS `NITs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `NITs` (
  `NitID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NumeroNIT` varchar(20) NOT NULL,
  `EmpresaID` int(10) unsigned DEFAULT NULL,
  `PersonaID` int(10) unsigned DEFAULT NULL,
  `EmpleadoID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`NitID`),
  UNIQUE KEY `NumeroNIT_UNIQUE` (`NumeroNIT`),
  KEY `fk_NITs_Empresas1_idx` (`EmpresaID`),
  KEY `fk_NITs_PersonaCliente1_idx` (`PersonaID`),
  KEY `fk_NITs_Empleados1_idx` (`EmpleadoID`),
  CONSTRAINT `fk_NITs_Empleados1` FOREIGN KEY (`EmpleadoID`) REFERENCES `Empleados` (`EmpleadoID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_NITs_Empresas1` FOREIGN KEY (`EmpresaID`) REFERENCES `Empresas` (`EmpresaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_NITs_PersonaCliente1` FOREIGN KEY (`PersonaID`) REFERENCES `PersonaCliente` (`PersonaID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PersonaCliente`
--

DROP TABLE IF EXISTS `PersonaCliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PersonaCliente` (
  `PersonaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`PersonaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Productos`
--

DROP TABLE IF EXISTS `Productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Productos` (
  `ProductoID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(50) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `ExcentoIVA` tinyint(1) NOT NULL DEFAULT '0',
  `StockMin` smallint(5) unsigned NOT NULL,
  `PrecioVenta` decimal(19,4) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Activo` tinyint(1) NOT NULL DEFAULT '1',
  `CategoriaProductoID` int(10) unsigned DEFAULT NULL,
  `CodigoLibroDet` varchar(2) NOT NULL,
  `CodigoBienDet` varchar(2) NOT NULL,
  `MarcaID` int(10) unsigned DEFAULT NULL,
  `MedidaID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ProductoID`),
  UNIQUE KEY `Productos_Codigo_UNIQUE` (`Codigo`),
  KEY `fk_Productos_CategoriaProductos_idx` (`CategoriaProductoID`),
  KEY `fk_Productos_ReferenciaLibroDet1_idx` (`CodigoLibroDet`),
  KEY `fk_Productos_CategoriasBienDet1_idx` (`CodigoBienDet`),
  KEY `fk_Productos_Marcas1_idx` (`MarcaID`),
  KEY `fk_Productos_Medidas1_idx` (`MedidaID`),
  FULLTEXT KEY `Productos_Descripcion_FULLTEXT` (`Descripcion`),
  CONSTRAINT `fk_Productos_CategoriaProductos` FOREIGN KEY (`CategoriaProductoID`) REFERENCES `CategoriaProductos` (`CategoriaProductoID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_Productos_CategoriasBienDet1` FOREIGN KEY (`CodigoBienDet`) REFERENCES `CategoriasBienDet` (`CodigoBienDet`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_Productos_Marcas1` FOREIGN KEY (`MarcaID`) REFERENCES `Marcas` (`MarcaID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_Productos_Medidas1` FOREIGN KEY (`MedidaID`) REFERENCES `Medidas` (`MedidaID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_Productos_ReferenciaLibroDet1` FOREIGN KEY (`CodigoLibroDet`) REFERENCES `ReferenciaLibroDet` (`CodigoLibroDet`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ReferenciaLibroDet`
--

DROP TABLE IF EXISTS `ReferenciaLibroDet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ReferenciaLibroDet` (
  `CodigoLibroDet` varchar(2) NOT NULL,
  `Descripcion` varchar(40) NOT NULL,
  PRIMARY KEY (`CodigoLibroDet`),
  UNIQUE KEY `Descripcion_UNIQUE` (`Descripcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Telefonos`
--

DROP TABLE IF EXISTS `Telefonos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Telefonos` (
  `TelefonoID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Telefono` varchar(30) NOT NULL,
  `EmpresaID` int(10) unsigned DEFAULT NULL,
  `PersonaID` int(10) unsigned DEFAULT NULL,
  `EmpleadoID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`TelefonoID`),
  KEY `fk_Telefonos_Empresas1_idx` (`EmpresaID`),
  KEY `fk_Telefonos_PersonaCliente1_idx` (`PersonaID`),
  KEY `fk_Telefonos_Empleados1_idx` (`EmpleadoID`),
  CONSTRAINT `fk_Telefonos_Empleados1` FOREIGN KEY (`EmpleadoID`) REFERENCES `Empleados` (`EmpleadoID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Telefonos_Empresas1` FOREIGN KEY (`EmpresaID`) REFERENCES `Empresas` (`EmpresaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Telefonos_PersonaCliente1` FOREIGN KEY (`PersonaID`) REFERENCES `PersonaCliente` (`PersonaID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TiposFactura`
--

DROP TABLE IF EXISTS `TiposFactura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TiposFactura` (
  `TipoFacturaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`TipoFacturaID`),
  UNIQUE KEY `Nombre_UNIQUE` (`Nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TirajeFacturas`
--

DROP TABLE IF EXISTS `TirajeFacturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TirajeFacturas` (
  `TirajeFacturaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoTiraje` varchar(50) NOT NULL,
  `NumeroFacturaActual` int(11) NOT NULL,
  `TirajeDesde` int(11) NOT NULL,
  `TirajeHasta` int(11) NOT NULL,
  PRIMARY KEY (`TirajeFacturaID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Usuarios`
--

DROP TABLE IF EXISTS `Usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Usuarios` (
  `EmpleadoID` int(10) unsigned NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`EmpleadoID`),
  UNIQUE KEY `Username_UNIQUE` (`Username`),
  CONSTRAINT `fk_Usuarios_Empleados1` FOREIGN KEY (`EmpleadoID`) REFERENCES `Empleados` (`EmpleadoID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-23  4:18:24
