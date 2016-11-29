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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Almacenes`
--

LOCK TABLES `Almacenes` WRITE;
/*!40000 ALTER TABLE `Almacenes` DISABLE KEYS */;
INSERT INTO `Almacenes` VALUES (1,'Casa Matríz'),(2,'Sucursal San Salvador');
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
  `Nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`CategoriaProductoID`),
  UNIQUE KEY `Nombre_UNIQUE` (`Nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CategoriaProductos`
--

LOCK TABLES `CategoriaProductos` WRITE;
/*!40000 ALTER TABLE `CategoriaProductos` DISABLE KEYS */;
INSERT INTO `CategoriaProductos` VALUES ('HM','Herramientas Manuales'),('PT','Pinturas');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ClientesPersonas`
--

LOCK TABLES `ClientesPersonas` WRITE;
/*!40000 ALTER TABLE `ClientesPersonas` DISABLE KEYS */;
INSERT INTO `ClientesPersonas` VALUES (1,'Javier','Portillo','5641681','651684681'),(2,'Marina','Portillo','75823727','78578');
/*!40000 ALTER TABLE `ClientesPersonas` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DetalleAlmacenes`
--

LOCK TABLES `DetalleAlmacenes` WRITE;
/*!40000 ALTER TABLE `DetalleAlmacenes` DISABLE KEYS */;
INSERT INTO `DetalleAlmacenes` VALUES (1,150,1,1),(2,100,1,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DetalleFactura`
--

LOCK TABLES `DetalleFactura` WRITE;
/*!40000 ALTER TABLE `DetalleFactura` DISABLE KEYS */;
INSERT INTO `DetalleFactura` VALUES (1,25,10.0000,1,1),(2,30,0.0000,1,1),(3,10,15.0000,1,1);
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
  `FechaIngreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ProductoID` int(10) unsigned NOT NULL,
  `EmpresaID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`DetalleIngresosID`),
  KEY `fk_DetalleIngresos_Productos1_idx` (`ProductoID`),
  KEY `fk_DetalleIngresos_Empresas1_idx` (`EmpresaID`),
  CONSTRAINT `fk_DetalleIngresos_Empresas1` FOREIGN KEY (`EmpresaID`) REFERENCES `Empresas` (`EmpresaID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_DetalleIngresos_Productos1` FOREIGN KEY (`ProductoID`) REFERENCES `Productos` (`ProductoID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DetalleIngresos`
--

LOCK TABLES `DetalleIngresos` WRITE;
/*!40000 ALTER TABLE `DetalleIngresos` DISABLE KEYS */;
INSERT INTO `DetalleIngresos` VALUES (1,100,15.0000,'2016-11-23 07:47:06',1,1),(2,100,15.3500,'2016-11-26 05:46:37',1,1),(3,35,15.6700,'2016-11-26 05:47:15',1,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Direcciones`
--

LOCK TABLES `Direcciones` WRITE;
/*!40000 ALTER TABLE `Direcciones` DISABLE KEYS */;
INSERT INTO `Direcciones` VALUES (1,'El Salvador','San Salvador','San Salvador','Bo. El Barrio, #1',1,NULL,NULL),(2,'El Salvador','San Salvador','San Salvador','Bo. El Calvario',NULL,NULL,1);
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
  UNIQUE KEY `Registro_UNIQUE` (`Registro`),
  UNIQUE KEY `NIT_UNIQUE` (`NIT`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='Empresas ya sean clientes o proveedores.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Empresas`
--

LOCK TABLES `Empresas` WRITE;
/*!40000 ALTER TABLE `Empresas` DISABLE KEYS */;
INSERT INTO `Empresas` VALUES (1,'Techos El Solazo!','Venta de techos.','Venta de techos','7516468-2','0511-156843-185-4'),(2,'Pisos El Temblor',NULL,'Venta de pisos.','68498165-5',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Facturas`
--

LOCK TABLES `Facturas` WRITE;
/*!40000 ALTER TABLE `Facturas` DISABLE KEYS */;
INSERT INTO `Facturas` VALUES (1,'2016-11-23 08:10:25',20001,1,NULL,1,NULL,NULL);
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
  PRIMARY KEY (`MarcaID`),
  UNIQUE KEY `Nombre_UNIQUE` (`Nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Marcas`
--

LOCK TABLES `Marcas` WRITE;
/*!40000 ALTER TABLE `Marcas` DISABLE KEYS */;
INSERT INTO `Marcas` VALUES (4,'3M'),(9,'ALLEN'),(7,'BLACK & DECKER'),(6,'BOSCH'),(10,'CRAFTSMAN'),(2,'DeWALT'),(8,'DREMEL'),(12,'IRWIN'),(11,'KARCHER'),(5,'Makita'),(3,'SKIL'),(1,'STANLEY');
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
  PRIMARY KEY (`MedidaID`),
  UNIQUE KEY `UnidadMedida_UNIQUE` (`UnidadMedida`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Medidas`
--

LOCK TABLES `Medidas` WRITE;
/*!40000 ALTER TABLE `Medidas` DISABLE KEYS */;
INSERT INTO `Medidas` VALUES (1,'cm');
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
  `Codigo` varchar(50) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `ExcentoIVA` tinyint(1) NOT NULL DEFAULT '0',
  `StockMin` smallint(5) unsigned NOT NULL,
  `PrecioVenta` decimal(19,4) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Productos`
--

LOCK TABLES `Productos` WRITE;
/*!40000 ALTER TABLE `Productos` DISABLE KEYS */;
INSERT INTO `Productos` VALUES (1,'0001','Los pollitos dicen: pio pio pio. Cuando tienen hambre, cuando tienen frio',0,5,10.5000,'2016-11-22 08:59:00','2016-11-26 02:06:15',1,'01','01',1,1,'HM'),(2,'0002','Había una vez un pollito que respiraba por las patitas, se paró en un charquito y se ahogó. Fin.',0,5,0.6500,'2016-11-23 08:30:22','2016-11-26 02:06:26',1,'01','02',5,1,'PT');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Telefonos`
--

LOCK TABLES `Telefonos` WRITE;
/*!40000 ALTER TABLE `Telefonos` DISABLE KEYS */;
INSERT INTO `Telefonos` VALUES (1,'22011008',1,NULL,NULL),(2,'73885967',NULL,NULL,1),(3,'20000000',NULL,NULL,1),(4,'71111111',NULL,NULL,2),(5,'60000000',NULL,NULL,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TiposFactura`
--

LOCK TABLES `TiposFactura` WRITE;
/*!40000 ALTER TABLE `TiposFactura` DISABLE KEYS */;
INSERT INTO `TiposFactura` VALUES (2,'Comprobante Crédito Fiscal'),(1,'Factura');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TirajeFacturas`
--

LOCK TABLES `TirajeFacturas` WRITE;
/*!40000 ALTER TABLE `TirajeFacturas` DISABLE KEYS */;
INSERT INTO `TirajeFacturas` VALUES (1,'16ZA000F',20001,30000);
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

-- Dump completed on 2016-11-28 18:56:04
