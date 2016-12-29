-- MySQL dump 10.15  Distrib 10.0.28-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.0.28-MariaDB-0ubuntu0.16.04.1

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
-- Dumping data for table `Almacenes`
--

LOCK TABLES `Almacenes` WRITE;
/*!40000 ALTER TABLE `Almacenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `Almacenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CategoriaProductos`
--

DROP TABLE IF EXISTS `CategoriaProductos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CategoriaProductos` (
  `CategoriaProductoID` varchar(2) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`CategoriaProductoID`),
  UNIQUE KEY `Nombre_UNIQUE` (`Nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CategoriaProductos`
--

LOCK TABLES `CategoriaProductos` WRITE;
/*!40000 ALTER TABLE `CategoriaProductos` DISABLE KEYS */;
INSERT INTO `CategoriaProductos` VALUES ('00','JARDINERIA',1),('01','PERNO GRADO 5 R/F',1),('02','PERNO HEXAG. GRADO 2',1),('03','PINTURA ANTICORROSIVA',1);
/*!40000 ALTER TABLE `CategoriaProductos` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `CategoriasBienDet`
--

LOCK TABLES `CategoriasBienDet` WRITE;
/*!40000 ALTER TABLE `CategoriasBienDet` DISABLE KEYS */;
INSERT INTO `CategoriasBienDet` VALUES ('04','Bien para la Construcción'),('03','Materia Prima'),('02','Productos en Proceso'),('01','Productos Terminados');
/*!40000 ALTER TABLE `CategoriasBienDet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ClientesPersonas`
--

DROP TABLE IF EXISTS `ClientesPersonas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ClientesPersonas` (
  `ClientesPersonasID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombres` varchar(255) NOT NULL,
  `Apellidos` varchar(255) NOT NULL,
  `DUI` varchar(15) DEFAULT NULL,
  `NIT` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ClientesPersonasID`),
  UNIQUE KEY `DUI_UNIQUE` (`DUI`),
  UNIQUE KEY `NIT_UNIQUE` (`NIT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ClientesPersonas`
--

LOCK TABLES `ClientesPersonas` WRITE;
/*!40000 ALTER TABLE `ClientesPersonas` DISABLE KEYS */;
/*!40000 ALTER TABLE `ClientesPersonas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Descuentos`
--

DROP TABLE IF EXISTS `Descuentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Descuentos` (
  `DescuentoID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `RazonDescuento` varchar(45) NOT NULL,
  `CantidadDescontada` decimal(19,4) NOT NULL,
  `ProductoID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`DescuentoID`),
  KEY `fk_Descuentos_Productos1_idx` (`ProductoID`),
  CONSTRAINT `fk_Descuentos_Productos1` FOREIGN KEY (`ProductoID`) REFERENCES `Productos` (`ProductoID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Descuentos`
--

LOCK TABLES `Descuentos` WRITE;
/*!40000 ALTER TABLE `Descuentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `Descuentos` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `DetalleAlmacenes`
--

LOCK TABLES `DetalleAlmacenes` WRITE;
/*!40000 ALTER TABLE `DetalleAlmacenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `DetalleAlmacenes` ENABLE KEYS */;
UNLOCK TABLES;

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
  `ProductoID` int(10) unsigned DEFAULT NULL,
  `FacturaID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`DetalleFacutaID`),
  KEY `fk_DetalleMovimientos_Productos1_idx` (`ProductoID`),
  KEY `fk_DetalleMovimientos_Facturas1_idx` (`FacturaID`),
  CONSTRAINT `fk_DetalleMovimientos_Facturas1` FOREIGN KEY (`FacturaID`) REFERENCES `Facturas` (`FacturaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_DetalleMovimientos_Productos1` FOREIGN KEY (`ProductoID`) REFERENCES `Productos` (`ProductoID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DetalleFactura`
--

LOCK TABLES `DetalleFactura` WRITE;
/*!40000 ALTER TABLE `DetalleFactura` DISABLE KEYS */;
/*!40000 ALTER TABLE `DetalleFactura` ENABLE KEYS */;
UNLOCK TABLES;

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
  `CostoActual` decimal(19,4) NOT NULL,
  `FechaIngreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ProductoID` int(10) unsigned NOT NULL,
  `EmpresaID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`DetalleIngresosID`),
  KEY `fk_DetalleIngresos_Productos1_idx` (`ProductoID`),
  KEY `fk_DetalleIngresos_Empresas1_idx` (`EmpresaID`),
  CONSTRAINT `fk_DetalleIngresos_Empresas1` FOREIGN KEY (`EmpresaID`) REFERENCES `Empresas` (`EmpresaID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_DetalleIngresos_Productos1` FOREIGN KEY (`ProductoID`) REFERENCES `Productos` (`ProductoID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DetalleIngresos`
--

LOCK TABLES `DetalleIngresos` WRITE;
/*!40000 ALTER TABLE `DetalleIngresos` DISABLE KEYS */;
/*!40000 ALTER TABLE `DetalleIngresos` ENABLE KEYS */;
UNLOCK TABLES;

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
  `EmpleadoID` int(10) unsigned DEFAULT NULL,
  `ClientesPersonasID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`DireccionID`),
  UNIQUE KEY `ClientesPersonasID_UNIQUE` (`ClientesPersonasID`),
  UNIQUE KEY `EmpleadoID_UNIQUE` (`EmpleadoID`),
  UNIQUE KEY `EmpresaID_UNIQUE` (`EmpresaID`),
  KEY `fk_Direcciones_Empresas1_idx` (`EmpresaID`),
  KEY `fk_Direcciones_Empleados1_idx` (`EmpleadoID`),
  KEY `fk_Direcciones_ClientesPersonas1_idx` (`ClientesPersonasID`),
  CONSTRAINT `fk_Direcciones_ClientesPersonas1` FOREIGN KEY (`ClientesPersonasID`) REFERENCES `ClientesPersonas` (`ClientesPersonasID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Direcciones_Empleados1` FOREIGN KEY (`EmpleadoID`) REFERENCES `Empleados` (`EmpleadoID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Direcciones_Empresas1` FOREIGN KEY (`EmpresaID`) REFERENCES `Empresas` (`EmpresaID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Direcciones`
--

LOCK TABLES `Direcciones` WRITE;
/*!40000 ALTER TABLE `Direcciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `Direcciones` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `Emails`
--

LOCK TABLES `Emails` WRITE;
/*!40000 ALTER TABLE `Emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `Emails` ENABLE KEYS */;
UNLOCK TABLES;

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
  `DUI` varchar(15) DEFAULT NULL,
  `NIT` varchar(20) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `NUP` varchar(25) DEFAULT NULL,
  `ISSS` varchar(15) DEFAULT NULL,
  `FechaNacimiento` date DEFAULT NULL,
  `Codigo` varchar(5) NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`EmpleadoID`),
  UNIQUE KEY `Codigo_UNIQUE` (`Codigo`),
  UNIQUE KEY `NUP_UNIQUE` (`NUP`),
  UNIQUE KEY `ISSS_UNIQUE` (`ISSS`),
  UNIQUE KEY `DUI_UNIQUE` (`DUI`),
  UNIQUE KEY `NIT_UNIQUE` (`NIT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Empleados`
--

LOCK TABLES `Empleados` WRITE;
/*!40000 ALTER TABLE `Empleados` DISABLE KEYS */;
/*!40000 ALTER TABLE `Empleados` ENABLE KEYS */;
UNLOCK TABLES;

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
  `NIT` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`EmpresaID`),
  UNIQUE KEY `NombreComercial_UNIQUE` (`NombreComercial`),
  UNIQUE KEY `NIT_UNIQUE` (`NIT`),
  UNIQUE KEY `Registro_UNIQUE` (`Registro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Empresas ya sean clientes o proveedores.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Empresas`
--

LOCK TABLES `Empresas` WRITE;
/*!40000 ALTER TABLE `Empresas` DISABLE KEYS */;
/*!40000 ALTER TABLE `Empresas` ENABLE KEYS */;
UNLOCK TABLES;

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
  `EmpleadoID` int(10) unsigned DEFAULT NULL,
  `TirajeFacturaID` int(10) unsigned NOT NULL,
  `EmpresaID` int(10) unsigned DEFAULT NULL COMMENT 'La empresa cliente',
  `ClientesPersonasID` int(10) unsigned DEFAULT NULL COMMENT 'La persona cliente',
  PRIMARY KEY (`FacturaID`),
  KEY `fk_Facturas_TiposFactura1_idx` (`TipoFacturaID`),
  KEY `fk_Facturas_Empleados1_idx` (`EmpleadoID`),
  KEY `fk_Facturas_TirajeFacturas1_idx` (`TirajeFacturaID`),
  KEY `fk_Facturas_Empresas1_idx` (`EmpresaID`),
  KEY `fk_Facturas_ClientesPersonas1_idx` (`ClientesPersonasID`),
  CONSTRAINT `fk_Facturas_ClientesPersonas1` FOREIGN KEY (`ClientesPersonasID`) REFERENCES `ClientesPersonas` (`ClientesPersonasID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_Facturas_Empleados1` FOREIGN KEY (`EmpleadoID`) REFERENCES `Empleados` (`EmpleadoID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_Facturas_Empresas1` FOREIGN KEY (`EmpresaID`) REFERENCES `Empresas` (`EmpresaID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_Facturas_TiposFactura1` FOREIGN KEY (`TipoFacturaID`) REFERENCES `TiposFactura` (`TipoFacturaID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_Facturas_TirajeFacturas1` FOREIGN KEY (`TirajeFacturaID`) REFERENCES `TirajeFacturas` (`TirajeFacturaID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Facturas`
--

LOCK TABLES `Facturas` WRITE;
/*!40000 ALTER TABLE `Facturas` DISABLE KEYS */;
/*!40000 ALTER TABLE `Facturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Marcas`
--

DROP TABLE IF EXISTS `Marcas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Marcas` (
  `MarcaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`MarcaID`),
  UNIQUE KEY `Nombre_UNIQUE` (`Nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Marcas`
--

LOCK TABLES `Marcas` WRITE;
/*!40000 ALTER TABLE `Marcas` DISABLE KEYS */;
INSERT INTO `Marcas` VALUES (3,'TRUPER',1),(4,'S/MARCA',1),(5,'IMACASA',1),(6,'TOOLCRAFT',1),(7,'EASY FLOW',1),(8,'TYPSA',1),(9,'AQUA FLEX',1),(10,'VARIEDAD',1),(11,'HS',1),(12,'AMANCO',1),(13,'VIKINGO',1),(14,'GREE GARDEN TAL TOOLS',1),(15,'IMACASA 19692P7',1),(16,'SCJONSON',1),(17,'PRETUL',1),(18,'SURTEK',1),(19,'TRAMOTINA',1),(20,'S/M SENCILLO',1),(21,'PLY GARDEN',1),(22,'PLASTICO',1),(23,'VOLTECH',1),(24,'HEMBRA',1),(25,'GANGL',1),(26,'ATLAS',1),(27,'DIESEL TOOL',1),(28,'VIVA',1),(29,'TRAMONTINA',1),(30,'TAL TOOLS',1),(31,'BRINK GARDEN',1),(32,'HOSE SHUT OFF',1),(33,'HOSE CHUT OFF',1),(34,'BEST GARDEN',1),(35,'SUR FASTYL',1),(36,'CORONA',1),(37,'KORAL SUR',1),(38,'POLYURETHENE P/ACABADO',1),(39,'MEGACOLOR',1),(40,'LANCO',1),(41,'SUR KLASS',1),(42,'SPRINKLER',1),(43,'VERMONT',1),(44,'TOOL CRAFT',1);
/*!40000 ALTER TABLE `Marcas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Medidas`
--

DROP TABLE IF EXISTS `Medidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Medidas` (
  `MedidaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UnidadMedida` varchar(100) NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`MedidaID`),
  UNIQUE KEY `UnidadMedida_UNIQUE` (`UnidadMedida`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Medidas`
--

LOCK TABLES `Medidas` WRITE;
/*!40000 ALTER TABLE `Medidas` DISABLE KEYS */;
INSERT INTO `Medidas` VALUES (3,'UNIDAD',1),(4,'PAR',1),(5,'CUARTO 1/4.',1),(6,'GALÓN',1);
/*!40000 ALTER TABLE `Medidas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Productos`
--

DROP TABLE IF EXISTS `Productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Productos` (
  `ProductoID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(20) NOT NULL,
  `Descripcion` varchar(50) NOT NULL,
  `ExcentoIVA` tinyint(1) NOT NULL DEFAULT '0',
  `StockMin` int(10) unsigned NOT NULL DEFAULT '1',
  `Utilidad` decimal(19,4) unsigned NOT NULL DEFAULT '0.0000',
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Activo` tinyint(1) NOT NULL DEFAULT '1',
  `CodigoLibroDet` varchar(2) NOT NULL,
  `CodigoBienDet` varchar(2) NOT NULL,
  `MarcaID` int(10) unsigned DEFAULT NULL,
  `MedidaID` int(10) unsigned DEFAULT NULL,
  `CategoriaProductoID` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`ProductoID`),
  UNIQUE KEY `Productos_Codigo_UNIQUE` (`Codigo`),
  KEY `fk_Productos_ReferenciaLibroDet1_idx` (`CodigoLibroDet`),
  KEY `fk_Productos_CategoriasBienDet1_idx` (`CodigoBienDet`),
  KEY `fk_Productos_Marcas1_idx` (`MarcaID`),
  KEY `fk_Productos_Medidas1_idx` (`MedidaID`),
  KEY `fk_Productos_CategoriaProductos1_idx` (`CategoriaProductoID`),
  FULLTEXT KEY `Productos_Descripcion_FULLTEXT` (`Descripcion`),
  CONSTRAINT `fk_Productos_CategoriaProductos1` FOREIGN KEY (`CategoriaProductoID`) REFERENCES `CategoriaProductos` (`CategoriaProductoID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_Productos_CategoriasBienDet1` FOREIGN KEY (`CodigoBienDet`) REFERENCES `CategoriasBienDet` (`CodigoBienDet`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_Productos_Marcas1` FOREIGN KEY (`MarcaID`) REFERENCES `Marcas` (`MarcaID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_Productos_Medidas1` FOREIGN KEY (`MedidaID`) REFERENCES `Medidas` (`MedidaID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_Productos_ReferenciaLibroDet1` FOREIGN KEY (`CodigoLibroDet`) REFERENCES `ReferenciaLibroDet` (`CodigoLibroDet`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=277 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Productos`
--

LOCK TABLES `Productos` WRITE;
/*!40000 ALTER TABLE `Productos` DISABLE KEYS */;
INSERT INTO `Productos` VALUES (1,'MSTRPR62122365','ATOMIZADOR PEQUEÑO',0,1,1.1320,'2016-12-27 09:49:12','2016-12-27 09:49:12',1,'03','01',3,3,'00'),(2,'MSTRPR200736849','BOLSA PLASTICA JARDINERA',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',4,3,'00'),(3,'MSTRPR82784720','BOTAS INDUSTRIALES TALLA 8',0,1,2.7650,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',3,4,'00'),(4,'17923BOT-27J','BOTAS JARDINERAS TALLA 9',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',3,4,'00'),(5,'BOT-26J','BOTAS INDUSTRIALES TALLA 8',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',3,4,'00'),(6,'BOT-28J','BOTAS JARDINERAS TALLA 10',0,1,0.0000,'2016-12-27 09:49:13','2016-12-28 05:57:38',1,'03','01',26,4,'00'),(7,'BOT-29J','BOTAS JARDINERAS TALLA 11',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',3,4,'00'),(10,'CAB-ATON','CABEZA ATOMIZADOR',0,1,1.3450,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',5,3,'00'),(12,'TC3210','DESBROZADORA ELECTRICA',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',6,3,'00'),(13,'MSTRPR63559309','EMPAQUE PARA MANGUERA',0,1,0.0930,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',3,3,'00'),(14,'TC2024','MANGUERA P/AIRE ALTA PRESION 3/8X10MTS',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',6,3,'00'),(15,'2005441','MANGUERA PLASTICA de 167MTS-50\'',0,1,4.1920,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',7,3,'00'),(16,'MSTRPR23305203','MANGUERA PLASTICA DE 75\'',0,1,2.7900,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',8,3,'00'),(17,'MSTRPR163384350','MANGUERA PLASTICA 100 PIE',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',7,3,'00'),(18,'MSTRPR187933255','MANGUERA PLASTICA DE 50 PIE',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',7,3,'00'),(19,'MSTRPR357585179','MANGUERA PLASTICA DE 25 PIE',0,1,2.2400,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',8,3,'00'),(20,'MSTRPR357252672','MANGUERA PLASTICA DE 100 PIE',0,1,3.1300,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',8,3,'00'),(21,'MSTRPR276784039','MANGUERA PLASTICA DE 50 PIE',0,1,2.8420,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',8,3,'00'),(22,'MSTRPR15666774','MANGUERA PLASTICA DE 150 PIE',0,1,3.1020,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',8,3,'00'),(23,'MSTRPR15797889','MANGUERA PLASTICA 125 PIE',0,1,2.9300,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',8,3,'00'),(24,'DU12','MANGUERA REFORZADA DE 25 PIE',0,1,3.7730,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',9,3,'00'),(25,'MSTRPR264445566','MANGUERA REFORZADA DE 22.5 MTS',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',7,3,'00'),(26,'MSTRPR264558907','MANGUERA REFORZADAN 7.5 MTS',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',7,3,'00'),(27,'DU14','MANGUERA REFORZADA 75 PIE',0,1,3.8650,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',9,3,'00'),(28,'MSTRPR284274517','MANGUERA REFORZADA 150 PIE',0,1,3.5200,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',9,3,'00'),(29,'2005553','MANGUERA REFORZADA DE 100 PIE',0,1,3.9850,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',7,3,'00'),(30,'DU13','MANGUERA REFORZADA DE 50 PIE',0,1,4.0600,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',9,3,'00'),(31,'DU15','MANGUERA REFORZADA DE 100 PIE',0,1,3.8600,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',9,3,'00'),(32,'MSTRPR151870891','MANGUERA REORZADA DE 125 PIE',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',9,3,'00'),(33,'MSTRPR66474732','MANGUERA TRANSPARENTE DE 1/2',0,1,0.1430,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',10,3,'00'),(34,'MGLS-0019','MANGUERA TRANSPARENTE DE 1/2',0,1,0.1930,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',11,3,'00'),(35,'MGLS-0021','MANGUERA TRANSPARENTE DE 3/4',0,1,0.4450,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',11,3,'00'),(36,'1840','MANGUERA TRANSPARENTE DE 3/4',0,1,0.2650,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',12,3,'00'),(37,'MGLS-0022','MANGUERA TRANSPARENTE DE 1\"',0,1,0.7100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',11,3,'00'),(38,'MSTRPR116816453','MANGUERA TRANSPARENTE DE 1\"',0,1,0.3700,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',12,3,'00'),(39,'MSTRPR62725751','PISTOLA P/MANGUERA',0,1,1.7500,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',13,3,'00'),(40,'TC0740','PISTOLA P/RIEGO METALICA',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',6,3,'00'),(41,'161301','PISTOLA PARA REGAR',0,1,0.8900,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',14,3,'00'),(42,'19690P','PISTOLA PLASTICA P/ MANGUERA',0,1,1.1830,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',5,3,'00'),(43,'MSTRPR49670887','PISTOLA PLATICA C/RECUBRIMIENT',0,1,1.9600,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',15,3,'00'),(44,'MSTRPR66279385','PITON P/MANGUERA METALICO',0,1,1.4500,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',5,3,'00'),(45,'299476','RAID H&G',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',16,3,'00'),(46,'MSTRPR14992817','RASTRILLO AMARILLO',0,1,2.0200,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',17,3,'00'),(47,'1965512 BLI','RASTRILLO LARGO 12 DIENTES VER',0,1,2.3530,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',5,3,'00'),(48,'MSTRPR340339340','RASTRILLO METALICO 22 DIENTES',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',18,3,'00'),(49,'1967016','RASTRILLO METALICO DE 22DI 16\"',0,1,1.8430,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',5,3,'00'),(50,'MSTRPR62375797','RASTRILLO METALICO RECTO',0,1,1.9100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',3,3,'00'),(51,'31696','RASTRILLO METALICO REFORZ.22 D',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',6,3,'00'),(52,'132050','RASTRILLO PLASTICO',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',18,3,'00'),(53,'MSTRPR94338297','RASTRILLO PLÁSTICO',0,1,2.2000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',19,3,'00'),(54,'6156','RASTRILLO PLASTICO 22 DI',0,1,2.2330,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',3,3,'00'),(55,'MSTRPR277345875','RASTRILLO VERDE',0,1,2.8800,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',20,3,'00'),(56,'MSTRPR19799372','RESORTE P/TIJERA DE PODAR',0,1,0.6200,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',4,3,'00'),(57,'MSTRPR75931352','TERMINAL P/MANGUERA HEMBR MET',0,1,0.3350,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',21,3,'00'),(58,'MSTRPR15193078','TERMINAL P/MANGUERA HEMBRA DE 3/4',0,1,0.4400,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',22,3,'00'),(59,'19710H12PI','TERMINAL P/MANGUERA HEMBRA',0,1,0.6200,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',5,3,'00'),(60,'CM-3/4B','TERMINAL P/MANGUERA MACHO',0,1,0.9630,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',23,3,'00'),(61,'MSTRPR66784674','TERMINAL P/MANGUERA METALICA DE 1/2',0,1,1.0600,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',4,3,'00'),(62,'MSTRPR28777221','TERMINAL P/MANGUERA METALICO',0,1,0.4350,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',17,3,'00'),(63,'300635','TERMINAL P/MANGUERA METALICO DE 3/4',0,1,0.9330,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',4,3,'00'),(64,'MSTRPR66230553','TERMINAL P/MANGUERA PLASTICA DE 1/2',0,1,0.9700,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',4,3,'00'),(65,'MSTRPR363111904','TERMINAL P/MANGUERA PLASTICO',0,1,0.6100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',24,3,'00'),(66,'MSTRPR87937522','TERMINAL P/MANGUERA PLASTICO DE 3/4',0,1,0.8420,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',4,3,'00'),(67,'CF-3/4B','TERMINAL P/MANGURA HEMBRA',0,1,0.8630,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',23,3,'00'),(68,'TC1855','TERMINAL PLASTICO P/MANGUERA',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',6,3,'00'),(69,'T-75','TIJERA P/PODAR DE 10\"',0,1,1.7800,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',3,3,'00'),(70,'T-74','TIJERA P/PODAR',0,1,2.3230,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',3,3,'00'),(71,'MSTRPR64619196','TIJERA P/PODAR DE 8\"',0,1,2.1000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',25,3,'00'),(72,'SHR0193','TIJERA P/PODAR DE 9\"',0,1,1.9450,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',26,3,'00'),(73,'MSTRPR60312036','TIJERA P/PODAR DE 8\"',0,1,1.7700,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',27,3,'00'),(74,'MSTRPR272681560','TIJERA P/PODAR GRAMA GRANDE',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',28,3,'00'),(75,'TM-78330/125','TIJERA P/PODAR GRAMA GRANDE',0,1,1.9450,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',29,3,'00'),(76,'13850 195128  I','TIJERA P/PODAR GRAMA GRANDE',0,1,0.0000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',5,3,'00'),(77,'9856','TIJERA P/PODAR GRAMA GRANDE',0,1,2.2150,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',30,3,'00'),(78,'B12-G501-014','UNION P/MANGUERA',0,1,0.6800,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',31,3,'00'),(79,'2001020','YEE METALICA',0,1,1.6800,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',32,3,'00'),(80,'MSTRPR130125296','YEE PLASTICA',0,1,1.3120,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',33,3,'00'),(81,'MSTRPR90775211','YEE PLASTICA P/MANGUERA',0,1,1.2330,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',5,3,'00'),(82,'3121200','YEE PLASTICA P/MANGUERA',0,1,0.8930,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',34,3,'00'),(83,'PHRF-001','PULGADA 7/16X3\"',0,1,0.1000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(84,'PHRF-002','PULGADA 7/16X1\"',0,1,0.1300,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(85,'PHRF-003','PULGADA 7/16X2\"',0,1,0.1100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(86,'PHRF-004','PULGADA 7/16X4\"',0,1,0.1400,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(87,'PHRF-005','PULGADA 7/16X6\"',0,1,0.2100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(88,'PHRF-006','PULGADA 7/16X2 1/2\"',0,1,0.1900,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(89,'PHRF-007','PULGADA 7/16X5\"',0,1,0.1300,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(90,'PHRF-008','PULGADA 7/16X3 1/2\"',0,1,0.1100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(91,'PHRF-010','PULGADA 3/8X1/2\"',0,1,0.0700,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(92,'PHRF-011','PULGADA 3/8X2\"',0,1,0.2200,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(93,'PHRF-012','PULGADA 3/8X4\"',0,1,0.1400,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(94,'PHRF-013','PULGADA 3/8X3\"',0,1,0.1100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(95,'PHRF-014','PULGADA 3/8X2 1/2\"',0,1,0.1100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(96,'PHRF-015','PULGADA 3/8X4 1/2\"',0,1,0.2530,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(97,'PHRF-016','PULGADA 3/8X3 1/2\"',0,1,0.1100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',4,3,'01'),(98,'PHRF-O17','PULGADA 3/8X5\"',0,1,0.2100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(99,'PHRF-018','PULGADA 3/8X1 1/4\"',0,1,0.1300,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(100,'PHRF-O19','PULGADA 3/8X1 1/2\"',0,1,0.1100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(101,'PHRF-020','PULGADA 3/8X1\"',0,1,0.1400,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(102,'PHRF-021','PULGADA 3/8X6\"',0,1,0.2210,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(103,'PHRF-022','PULGADA 9/16X3 1/2\"',0,1,0.2400,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(104,'PHRF-023','PULGADA 9/16X4 1/2\"',0,1,0.2100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(105,'PHRF-024','PULGADA 9/16X1 1/4\"',0,1,0.2000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(106,'PHRF-025','PULGADA 9/16X5\"',0,1,0.2000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(107,'PHRF-026','PULGADA 9/16X4\"',0,1,0.2000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(108,'PHRF-027','PULGADA 9/16X1 1/2\"',0,1,0.2000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(109,'PHRF-028','PULGADA 9/16X2 1/2\"',0,1,0.0800,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(110,'PHRF-029','PULGADA 9/16X3\"',0,1,0.1100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(111,'PHRF-030','PULGADA 9/16X2\"',0,1,0.0800,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(112,'PHRF-031','PULGADA 9/16X6\"',0,1,0.2100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(113,'PHRF-032','PULGADA 1/2X5\"',0,1,0.1200,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(114,'PHRF-033','PULGADA 1/2X1\"',0,1,0.1300,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(115,'PHRF-034','PULGADA 1/2X6\"',0,1,0.5320,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(116,'PHRF-035','PULGADA 1/2X1 1/4\"',0,1,0.2200,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(117,'PHRF-036','PULGADA 1/2X3\"',0,1,0.1800,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(118,'PHRF-037','PULGADA 1/2X2 1/2\"',0,1,0.1100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(119,'PHRF-038','PULGADA 1/2X1 1/2\"',0,1,0.2630,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(120,'PHRF-039','PULGADA 1/2X3 1/2\"',0,1,0.1500,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(121,'PHRF-040','PULGADA 1/2X2\"',0,1,0.3050,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(122,'PHRF-041','PULGADA 5/16X3 1/2\"',0,1,0.1400,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(123,'PHRF-042','PULGADA 5/16X1 1/4\"',0,1,0.0720,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(124,'PHRF-043','PULGADA 5/16X1\"',0,1,0.1000,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','01',4,3,'01'),(125,'PHRF-044','PULGADA 5/16X1 1/2\"',0,1,0.1400,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(126,'PHRF-045','PULGADA 5/16X3/4\"',0,1,0.1100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(127,'PHRF-046','PULGADA 5/16X2\"',0,1,0.1100,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(128,'PHRF-047','PULGADA 5/16X5\"',0,1,0.1200,'2016-12-27 09:49:13','2016-12-27 09:49:13',1,'03','04',4,3,'01'),(129,'PHRF-049','PULGADA 5/16X6\"',0,1,0.1200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'01'),(130,'PHRF-050','PULGADA 5/16X3\"',0,1,0.1300,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'01'),(131,'PHRF-051','PULGADA 5/16X4\"',0,1,0.1300,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'01'),(132,'PHRF-052','PULGADA 5/16X2 1/2\"',0,1,0.1460,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'01'),(133,'PHRF-053','PULGADA 1/4X5\"',0,1,0.1300,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'01'),(134,'PHRF-054','PULGADA 1/4X3\"',0,1,0.2200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'01'),(135,'PHRF-055','PULGADA 1/4X4\"',0,1,0.1200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'01'),(136,'PHRF-056','PULGADA 1/4X6\"',0,1,0.1400,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'01'),(137,'PHRF-057','PULGADA 1/4X1\"',0,1,0.1200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'01'),(138,'PHRF-058','PULGADA 1/4X2\"',0,1,0.1200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'01'),(139,'PHRF-059','PULGADA 1/4X3 1/2\"',0,1,0.1200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'01'),(140,'PHRF-060','PULGADA 1/4X2 1/2\"',0,1,0.1100,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'01'),(141,'PHRF-061','PULGADA 1/4X1 1/2\"',0,1,0.1200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'01'),(142,'PHRF-062','PULGADA 1/4X1 1/4\"',0,1,0.0900,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'01'),(143,'PHRF-063','PULGADA 1/4X3/4\"',0,1,0.0900,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'01'),(144,'PHRF-64','PULGADA 1/2X4\"',0,1,0.1500,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'01'),(145,'MSTRPR242551869','PULGADA 3/8 X 3/4\"',0,1,0.0000,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'01'),(146,'MSTRPR242428294','PULGADA 7/16 X 1 1/2',0,1,0.0000,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'01'),(147,'MSTRPR242236461','PULGADA 7/16X3\"',0,1,0.0000,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'01'),(148,'PHG2-053','PULGADA 1/2X1 1/2\"',0,1,0.2230,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(149,'PHG2-051','PULGADA 1/2X1\"',0,1,0.2000,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(150,'PHG2-064','PULGADA 1/2X10\"',0,1,0.4000,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(151,'PHG2-055','PULGADA 1/2X2 1/2\"',0,1,0.4200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(152,'PHG2¨-054','PULGADA 1/2X2\"',0,1,0.1810,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(153,'PHG2-057','PULGADA 1/2X3 1/2\"',0,1,0.3400,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(154,'PHG2-056','PULGADA 1/2X3\"',0,1,0.1230,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(155,'PHG2-059','PULGADA 1/2X4 1/2\"',0,1,0.2200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(156,'PHG2-058','PULGADA 1/2X4\"',0,1,0.2500,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(157,'PHG2-69','PULGADA 1/2X5\"',0,1,0.0860,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(158,'PHG2-061','PULGADA 1/2X6\"',0,1,0.3600,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(159,'PHG2-067','PULGADA 1/2X7\"',0,1,0.3600,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(160,'PHG2-063','PULGADA 1/2X8\"',0,1,0.3600,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(161,'PHG2-005','PULGADA 1/4X1 1/2\"',0,1,0.1300,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(162,'PHG2-004','PULGADA 1/4X1 1/4\"',0,1,0.1400,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(163,'PHG2-003','PULGADA 1/4X1\"',0,1,0.0900,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(164,'PHG2-002','PULGADA 1/4X1/2\"',0,1,0.0800,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(165,'PHG2-007','PULGADA 1/4X2 1/2\"',0,1,0.1200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(166,'PHG2-006','PULGADA 1/4X2\"',0,1,0.1300,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(167,'PHG2-009','PULGADA 1/4X3 1/2\"',0,1,0.2200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(168,'PHG-003.','PULGADA 1/4X3\"',0,1,0.1300,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','02',4,3,'02'),(169,'PHG2-001','PULGADA 1/4X3/4\"',0,1,0.0930,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(170,'PHG2-012','PULGADA 1/4X4 1/2\"',0,1,0.1100,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(171,'PHG2-010','PULGADA 1/4X4\"',0,1,0.1120,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(172,'PHG-005.','PULGADA 1/4X5\"',0,1,0.1100,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(173,'PHG2-013','PULGADA 1/4X6\"',0,1,0.1800,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(174,'PHG2-074','PULGADA 3/4X1 1/2\"',0,1,0.4200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(175,'PHG2-076','PULGADA 3/4X2 1/2\"',0,1,0.4000,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(176,'PHG2-075','PULGADA 3/4X2\"',0,1,0.4200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(177,'PHG2-078','PULGADA 3/4X3 1/2\"',0,1,0.3000,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(178,'PHG2-081','PULGADA 3/4X6\"',0,1,0.3600,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(179,'PHG2-030','PULGADA 3/8X1 1/2\"',0,1,0.1660,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(180,'PHG2-029','PULGADA 3/8X1 1/4\"',0,1,0.1760,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(181,'PHG2-028','PULGADA 3/8X1\"',0,1,0.1320,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(182,'PHG2-040','PULGADA 3/8X10\"',0,1,0.1500,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(183,'PHG2-032','PULGADA 3/8X2 1/2\"',0,1,0.1800,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(184,'PHG2-31','PULGADA 3/8X2\"',0,1,0.1900,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(185,'PHG2-034','PULGADA 3/8X3 1/2\"',0,1,0.1840,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(186,'PHG2-033','PULGADA 3/8X3\"',0,1,0.1940,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(187,'PHG2-027','PULGADA 3/8X3/4\"',0,1,0.1000,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(188,'PHG2-035','PULGADA 3/8X4\"',0,1,0.2000,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(189,'PHG2-036','PULGADA 3/8X5\"',0,1,0.2200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(190,'PHG2-037','PULGADA 3/8X6\"',0,1,0.3130,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(191,'PHG2-038','PULGADA 3/8X7\"',0,1,0.3050,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(192,'PHG2.039','PULGADA 3/8X8\"',0,1,0.3400,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(193,'PHG2-017','PULGADA 5/16X1 1/2\"',0,1,0.1520,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(194,'PHG2-015','PULGADA 5/16X1 1/4\"',0,1,0.0700,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(195,'PHG2-016','PULGADA 5/16X1\"',0,1,0.1200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(196,'PHG2-019','PULGADA 5/16X2 1/2\"',0,1,0.1760,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(197,'PHG2-018','PULGADA 5/16X2\"',0,1,0.2300,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(198,'PHG2-021','PULGADA 5/16X3 1/2\"',0,1,0.2040,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(199,'PHG2-020','PULGADA 5/16X3\"',0,1,0.3500,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(200,'PHG2-014','PULGADA 5/16X3/4\"',0,1,0.1300,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(201,'PHG2-023','PULGADA 5/16X4 1/2\"',0,1,0.1400,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(202,'PHG2-022','PULGADA 5/16X4\"',0,1,0.2040,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(203,'PHG2-024','PULGADA 5/16X5\"',0,1,0.1740,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(204,'PHG2-025','PULGADA 5/16X6\"',0,1,0.1800,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(205,'PHG20-065','PULGADA 5/8X1 1/2\"',0,1,0.4500,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(206,'PHG2-066','PULGADA 5/8X2\"',0,1,0.5300,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(207,'PHG2--069','PULGADA 5/8X3\"',0,1,0.5300,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(208,'PHG2-070','PULGADA 5/8X4\"',0,1,0.4000,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(209,'PHG2--071','PULGADA 5/8X5\"',0,1,0.3200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(210,'PHG2-072','PULGADA 5/8X6\"',0,1,0.3000,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(211,'PHG2-073','PULGADA 5/8X7\"',0,1,0.7530,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(212,'PHG2-043','PULGADA 7/16X1 1/2\"',0,1,0.2300,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(213,'PHG2-042','PULGADA 7/16X1 1/4\"',0,1,0.2100,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(214,'PHG2-041','PULGADA 7/16X1\"',0,1,0.1500,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(215,'PHG2-045','PULGADA 7/16x2 1/2\"',0,1,0.1040,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(216,'PHG2-044','PULGADA 7/16X2\"',0,1,0.0900,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(217,'PHG2-047','PULGADA 7/16x3 1/2\"',0,1,0.1100,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(218,'PHG2-046','PULGADA 7/16x3\"',0,1,0.0900,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',4,3,'02'),(219,'PHG2-048','PULGADA 7/16x4\"',0,1,0.1510,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(220,'PHG2-049','PULGADA 7/16x5\"',0,1,0.3130,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(221,'PHG2-050','PULGADA 7/16x6\"',0,1,0.2660,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',4,3,'02'),(222,'005-45700-14','NEGRO',0,1,1.3200,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',35,5,'03'),(223,'2900 - 04','ROJO OXIDO',0,1,1.7400,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,5,'03'),(224,'2901 - 04','NEGRO MATE',0,1,1.7430,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,5,'03'),(225,'2902 - 04','GRIS MATE',0,1,1.7530,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,5,'03'),(226,'2904 - 04','VERDE MATE',0,1,1.7530,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,5,'03'),(227,'2905 - 04','MINIO NARANJA',0,1,1.7530,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,5,'03'),(228,'2906 - 04','BLANCO MATE',0,1,1.7430,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,5,'03'),(229,'2907 - 04','NEGRO BRILLANTE',0,1,1.3000,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,5,'03'),(230,'2908 - 04','AZUL MATE',0,1,1.7530,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,5,'03'),(231,'2909 - 04','BLANCO BRILLANTE',0,1,1.7430,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',36,5,'03'),(232,'2910 - 04','GRIS BRILLANTE',0,1,1.7530,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',36,5,'03'),(233,'2911-04','ROJO OXIDO BRILLANTE',0,1,1.7530,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,5,'03'),(234,'2912 - 04','VERDE BRILLANTE',0,1,1.7530,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',36,5,'03'),(235,'506-02300-800-14','PINTURA ALUMINIO',0,1,2.3130,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',37,5,'03'),(236,'509-00380-700-14','PINTURA ANTIGRAVA KLASS',0,1,1.8850,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',38,5,'03'),(237,'7302-04','ROJO OXIDO',0,1,1.2830,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',39,5,'03'),(238,'9500-04','BLANCO FAST DRY',0,1,1.7800,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,5,'03'),(239,'9501-04','NEGRO FAST DRY',0,1,1.2530,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,5,'03'),(240,'9502-04','ROJO FAST DRY',0,1,1.7800,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,5,'03'),(241,'9503-04','VERDE FAST DRY',0,1,1.7800,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,5,'03'),(242,'AC3436-5','AZUL INDUSTRIAL',0,1,1.3250,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',40,5,'03'),(243,'AC3437-5','ROJO INDUSTRIAL',0,1,1.3250,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',40,5,'03'),(244,'AC3439-5','VERDE INDUSTRIAL',0,1,0.0000,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',40,5,'03'),(245,'AC3440-5','AMARILLO INDUSTRIAL',0,1,1.3250,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',40,5,'03'),(246,'2900-01','ROJO OXIDO',0,1,3.7400,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,6,'03'),(247,'2901-01','NEGRO MATE',0,1,3.7400,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,6,'03'),(248,'2902-01','GRIS MATE',0,1,2.8550,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,6,'03'),(249,'2904-01 M2','VERDE MATE',0,1,3.7400,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,6,'03'),(250,'2905-01','MINIO NARANJA',0,1,3.7400,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,6,'03'),(251,'2906-01','BLANCO MATE',0,1,3.7400,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,6,'03'),(252,'2907-01','NEGRO BRILLANTE',0,1,2.8550,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','04',36,6,'03'),(253,'2908-01','AZUL MATE',0,1,3.7400,'2016-12-27 09:49:14','2016-12-27 09:49:14',1,'03','01',36,6,'03'),(254,'2909-01','BLANCO BRILLANTE',0,1,2.8550,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','04',36,6,'03'),(255,'2910-01','GRIS BRILLANTE',0,1,2.3000,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','04',36,6,'03'),(256,'2911-01','ROJO OXIDO BRILLANTE',0,1,2.4130,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','04',36,6,'03'),(257,'2912-01','VERDE BRILLANTE',0,1,3.8050,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','04',36,6,'03'),(258,'506-09100-701-06','PINTURA NEGRO CORROSTOP',0,1,2.3700,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',41,6,'03'),(259,'9500-01','BLANCO FAST DRY',0,1,1.7800,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',36,6,'03'),(260,'9501-01','NEGRO FAST DRY',0,1,1.7800,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',36,6,'03'),(261,'9502-01','ROJO FAST DRY',0,1,1.7800,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',36,6,'03'),(262,'9503-01','VERDE FAST DRY',0,1,1.7800,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',36,6,'03'),(263,'MSTRPR347690020','PINTURA ALUMINIO',0,1,5.6020,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',37,6,'03'),(264,'P07-4142','ASPERSOR C/BASE TIPO H',0,1,2.4800,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',42,3,'00'),(265,'19697P  I','ASPERSOR C/BASE TIPO H',0,1,0.0000,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',5,3,'00'),(266,'19693P','ASPERSOR DE ESTACA',0,1,1.5530,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',5,3,'00'),(267,'19693ML 2I','ASPERSOR DE ESTACA METALICO',0,1,2.1800,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',5,3,'00'),(268,'ASPRO-11X','ASPERSOR DE ESTACA PLASTICO',0,1,1.9400,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',17,3,'00'),(269,'1166714','ASPERSOR DE TRES ASPAS',0,1,0.0000,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',43,3,'00'),(270,'DOS-11X','ASPERSOR METALICO',0,1,2.1230,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',3,3,'00'),(271,'TC1876','ASPERSOR PTCO C/ESTACA METAL',0,1,0.0000,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',44,3,'00'),(272,'ATO-DOMO.5LI','ATOMIZADOR',0,1,1.0730,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',5,3,'00'),(273,'MSTRPR62581558','ATOMIZADOR GRANDE',0,1,1.2440,'2016-12-27 09:49:15','2016-12-27 09:49:15',1,'03','01',3,3,'00'),(274,'BOT-28S','BOTAS SANITARIAS TALLA 10',0,1,0.0000,'2016-12-27 20:10:27','2016-12-27 20:10:27',1,'03','01',3,4,'00'),(275,'MSTRPR82706656','BOTAS P/JARDINERO TALLA 8',0,1,2.6430,'2016-12-27 20:18:07','2016-12-27 20:18:07',1,'03','01',3,4,'00'),(276,'MSTRPR56878432','CESTA P/CORTAR FRUTAS',0,1,1.9320,'2016-12-27 20:18:28','2016-12-27 20:18:28',1,'03','01',5,3,'00');
/*!40000 ALTER TABLE `Productos` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `ReferenciaLibroDet`
--

LOCK TABLES `ReferenciaLibroDet` WRITE;
/*!40000 ALTER TABLE `ReferenciaLibroDet` DISABLE KEYS */;
INSERT INTO `ReferenciaLibroDet` VALUES ('03','Compras Locales'),('01','Costos'),('02','Retaceos');
/*!40000 ALTER TABLE `ReferenciaLibroDet` ENABLE KEYS */;
UNLOCK TABLES;

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
  `EmpleadoID` int(10) unsigned DEFAULT NULL,
  `ClientesPersonasID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`TelefonoID`),
  KEY `fk_Telefonos_Empresas1_idx` (`EmpresaID`),
  KEY `fk_Telefonos_Empleados1_idx` (`EmpleadoID`),
  KEY `fk_Telefonos_ClientesPersonas1_idx` (`ClientesPersonasID`),
  CONSTRAINT `fk_Telefonos_ClientesPersonas1` FOREIGN KEY (`ClientesPersonasID`) REFERENCES `ClientesPersonas` (`ClientesPersonasID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Telefonos_Empleados1` FOREIGN KEY (`EmpleadoID`) REFERENCES `Empleados` (`EmpleadoID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Telefonos_Empresas1` FOREIGN KEY (`EmpresaID`) REFERENCES `Empresas` (`EmpresaID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Telefonos`
--

LOCK TABLES `Telefonos` WRITE;
/*!40000 ALTER TABLE `Telefonos` DISABLE KEYS */;
/*!40000 ALTER TABLE `Telefonos` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TiposFactura`
--

LOCK TABLES `TiposFactura` WRITE;
/*!40000 ALTER TABLE `TiposFactura` DISABLE KEYS */;
/*!40000 ALTER TABLE `TiposFactura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TirajeFacturas`
--

DROP TABLE IF EXISTS `TirajeFacturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TirajeFacturas` (
  `TirajeFacturaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoTiraje` varchar(50) NOT NULL,
  `TirajeDesde` int(11) NOT NULL,
  `TirajeHasta` int(11) NOT NULL,
  PRIMARY KEY (`TirajeFacturaID`),
  UNIQUE KEY `CodigoTiraje_UNIQUE` (`CodigoTiraje`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TirajeFacturas`
--

LOCK TABLES `TirajeFacturas` WRITE;
/*!40000 ALTER TABLE `TirajeFacturas` DISABLE KEYS */;
/*!40000 ALTER TABLE `TirajeFacturas` ENABLE KEYS */;
UNLOCK TABLES;

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
  UNIQUE KEY `EmpleadoID_UNIQUE` (`EmpleadoID`),
  CONSTRAINT `fk_Usuarios_Empleados1` FOREIGN KEY (`EmpleadoID`) REFERENCES `Empleados` (`EmpleadoID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuarios`
--

LOCK TABLES `Usuarios` WRITE;
/*!40000 ALTER TABLE `Usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `Usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-29  1:23:37
