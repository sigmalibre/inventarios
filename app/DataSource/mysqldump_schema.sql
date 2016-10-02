-- MySQL dump 10.15  Distrib 10.0.27-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: inventarios
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
-- Table structure for table `MSysCompactError`
--

DROP TABLE IF EXISTS `MSysCompactError`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MSysCompactError` (
  `ErrorCode` int(10) DEFAULT NULL,
  `ErrorDescription` longtext COLLATE utf8mb4_unicode_ci,
  `ErrorRecid` varbinary(510) DEFAULT NULL,
  `ErrorTable` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbbodegas`
--

DROP TABLE IF EXISTS `tbbodegas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbbodegas` (
  `codigo_bod` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_bod` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `encargado_bod` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_bod` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_bod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbcategoriabiendet`
--

DROP TABLE IF EXISTS `tbcategoriabiendet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbcategoriabiendet` (
  `codigo_catbiendet` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_catbiendet` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_catbiendet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbcategoriaproductos`
--

DROP TABLE IF EXISTS `tbcategoriaproductos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbcategoriaproductos` (
  `codigo_cat` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_cat` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_cat`),
  KEY `tbcategoriaproductos_nombre_cat_idx` (`nombre_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbcliente`
--

DROP TABLE IF EXISTS `tbcliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbcliente` (
  `codigo_cln` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_cln` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido_cln` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NIT_cln` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DUI_cln` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_cln` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `municipio_cln` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departamento_cln` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_cln` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_cln`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbconfiguracion`
--

DROP TABLE IF EXISTS `tbconfiguracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbconfiguracion` (
  `codigo_user` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipocodbod_config` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipocodprov_config` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipocodmas_config` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipocodcat_config` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbconfiguracioniva`
--

DROP TABLE IF EXISTS `tbconfiguracioniva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbconfiguracioniva` (
  `iva` decimal(19,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbcorteinv`
--

DROP TABLE IF EXISTS `tbcorteinv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbcorteinv` (
  `codigo_corteinv` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_final` datetime DEFAULT NULL,
  `folio` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_corteinv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbcostos`
--

DROP TABLE IF EXISTS `tbcostos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbcostos` (
  `codigo_mas` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio1_cst` decimal(19,4) DEFAULT NULL,
  `precio2_cst` decimal(19,4) DEFAULT NULL,
  `precio3_cst` decimal(19,4) DEFAULT NULL,
  `precio4_cst` decimal(19,4) DEFAULT NULL,
  KEY `tbmastertbcostos` (`codigo_mas`),
  CONSTRAINT `tbmastertbcostos` FOREIGN KEY (`codigo_mas`) REFERENCES `tbmaster` (`codigo_mas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbdetallebodegas`
--

DROP TABLE IF EXISTS `tbdetallebodegas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbdetallebodegas` (
  `codigo_bod` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_mas` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` int(10) DEFAULT NULL,
  KEY `tbbodegastbdetallebodegas` (`codigo_bod`),
  KEY `tbmastertbdetallebodegas` (`codigo_mas`),
  CONSTRAINT `tbbodegastbdetallebodegas` FOREIGN KEY (`codigo_bod`) REFERENCES `tbbodegas` (`codigo_bod`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbmastertbdetallebodegas` FOREIGN KEY (`codigo_mas`) REFERENCES `tbmaster` (`codigo_mas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbdetallecorteinv`
--

DROP TABLE IF EXISTS `tbdetallecorteinv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbdetallecorteinv` (
  `codigo_corteinv` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_mas` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion_mas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `existencia` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ingresou` int(10) DEFAULT NULL,
  `egresou` int(10) DEFAULT NULL,
  `existenciasactual` int(10) DEFAULT NULL,
  `saldoactual` decimal(19,4) DEFAULT NULL,
  `ingresov` decimal(19,4) DEFAULT NULL,
  `egresov` decimal(19,4) DEFAULT NULL,
  `ventaneta` decimal(19,4) DEFAULT NULL,
  `utilidad` decimal(19,4) DEFAULT NULL,
  KEY `tbcorteinvtbdetallecorteinv` (`codigo_corteinv`),
  CONSTRAINT `tbcorteinvtbdetallecorteinv` FOREIGN KEY (`codigo_corteinv`) REFERENCES `tbcorteinv` (`codigo_corteinv`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbdetallefactura`
--

DROP TABLE IF EXISTS `tbdetallefactura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbdetallefactura` (
  `codigo_fct` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_mas` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad_fct` int(10) DEFAULT NULL,
  `descripcion_fct` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `costoprom_fct` decimal(19,4) DEFAULT NULL,
  `preciounitario_fct` decimal(19,4) DEFAULT NULL,
  `vexcentas_fct` decimal(19,4) DEFAULT NULL,
  `vafectas_fct` decimal(19,4) DEFAULT NULL,
  `iva_fct` decimal(19,4) DEFAULT NULL,
  `ivaretenido_fct` decimal(19,4) DEFAULT NULL,
  `vafectasiva_fct` decimal(19,4) DEFAULT NULL,
  KEY `tbmastertbdetallefactura` (`codigo_mas`),
  KEY `tbfacturatbdetallefactura` (`codigo_fct`),
  CONSTRAINT `tbfacturatbdetallefactura` FOREIGN KEY (`codigo_fct`) REFERENCES `tbfactura` (`codigo_fct`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbmastertbdetallefactura` FOREIGN KEY (`codigo_mas`) REFERENCES `tbmaster` (`codigo_mas`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbdetallemaster`
--

DROP TABLE IF EXISTS `tbdetallemaster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbdetallemaster` (
  `codigo_mas` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_detallem` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_mov` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saldou_detallem` int(10) DEFAULT NULL,
  `saldov_detallem` decimal(19,4) DEFAULT NULL,
  `cantidad_detallem` int(10) DEFAULT NULL,
  `valor_detallem` decimal(19,4) DEFAULT NULL,
  `salactu_detallem` int(10) DEFAULT NULL,
  `salactv_detallem` decimal(19,4) DEFAULT NULL,
  `promedio_detallem` decimal(19,4) DEFAULT NULL,
  `fecha_detallem` datetime DEFAULT NULL,
  `codigo_user` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechafactura_detallem` datetime DEFAULT NULL,
  KEY `tbusertbdetallemaster` (`codigo_user`),
  KEY `tbmastertbdetallemaster` (`codigo_mas`),
  KEY `tbtipomovtbdetallemaster` (`codigo_mov`),
  CONSTRAINT `tbmastertbdetallemaster` FOREIGN KEY (`codigo_mas`) REFERENCES `tbmaster` (`codigo_mas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbtipomovtbdetallemaster` FOREIGN KEY (`codigo_mov`) REFERENCES `tbtipomov` (`codigo_mov`) ON UPDATE CASCADE,
  CONSTRAINT `tbusertbdetallemaster` FOREIGN KEY (`codigo_user`) REFERENCES `tbuser` (`codigo_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbdetallesucursal`
--

DROP TABLE IF EXISTS `tbdetallesucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbdetallesucursal` (
  `codigo_bod` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_scr` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  KEY `tbbodegastbdetallesucursal` (`codigo_bod`),
  KEY `tbsucursalestbdetallesucursal` (`codigo_scr`),
  CONSTRAINT `tbbodegastbdetallesucursal` FOREIGN KEY (`codigo_bod`) REFERENCES `tbbodegas` (`codigo_bod`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbsucursalestbdetallesucursal` FOREIGN KEY (`codigo_scr`) REFERENCES `tbsucursales` (`codigo_scr`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbempleados`
--

DROP TABLE IF EXISTS `tbempleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbempleados` (
  `codigo_emp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_src` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombres_emp` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellidos_emp` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexo_emp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_emp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_emp` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cel_emp` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_emp` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dui_emp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nit_emp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nup_emp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isss_emp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechaingreso_emp` datetime DEFAULT NULL,
  `salario_emp` decimal(19,4) DEFAULT NULL,
  `nombreplaza_emp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_emp`),
  KEY `tbsucursalestbempleados` (`codigo_src`),
  CONSTRAINT `tbsucursalestbempleados` FOREIGN KEY (`codigo_src`) REFERENCES `inventariotmp`.`tbsucursales` (`codigo_scr`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbempresa`
--

DROP TABLE IF EXISTS `tbempresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbempresa` (
  `codigo_cmp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombrecomercial_cmp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razonsocial_cmp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presidente_cmp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ceo_cmp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `replegal_cmp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_cmp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `giro_cmp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_cmp` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono1_cmp` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono2_cmp` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefax_cmp` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nrc_cmp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nit_cmp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paginaweb_cmp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_cmp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbfactura`
--

DROP TABLE IF EXISTS `tbfactura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbfactura` (
  `codigo_fct` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_emp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_cln` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_scr` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `totalletra_fct` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suma_fct` decimal(19,4) DEFAULT NULL,
  `vexentas_fct` decimal(19,4) DEFAULT NULL,
  `subtotal_fct` decimal(19,4) DEFAULT NULL,
  `tipofactura_fct` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creditofiscal_fct` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ventatotal_fct` decimal(19,4) DEFAULT NULL,
  `fecha_factura` datetime DEFAULT NULL,
  `nombrerecibio_fct` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duirecibio_fct` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nitrecibio_fct` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telrecibio_fct` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombreentrego_fct` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facturadopor_fct` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notaremision_fct` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechanotaremision_fct` datetime DEFAULT NULL,
  `giro_fct` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicionespago` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_fct`),
  KEY `tbempleadostbfactura` (`codigo_emp`),
  KEY `tbsucursalestbfactura` (`codigo_scr`),
  CONSTRAINT `tbempleadostbfactura` FOREIGN KEY (`codigo_emp`) REFERENCES `tbempleados` (`codigo_emp`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tbsucursalestbfactura` FOREIGN KEY (`codigo_scr`) REFERENCES `tbsucursales` (`codigo_scr`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbmaster`
--

DROP TABLE IF EXISTS `tbmaster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbmaster` (
  `codigo_mas` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_prov` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_cat` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_subcat` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_mas` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_mas` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marca_mas` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excentoiva_mas` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saldou_mas` int(10) DEFAULT NULL,
  `saldov_mas` decimal(19,4) DEFAULT NULL,
  `ingresou_mas` int(10) DEFAULT NULL,
  `egresou_mas` int(10) DEFAULT NULL,
  `ingresov_mas` decimal(19,4) DEFAULT NULL,
  `egresov_mas` decimal(19,4) DEFAULT NULL,
  `promedio_mas` decimal(19,4) DEFAULT NULL,
  `fechaingreso_mas` datetime DEFAULT NULL,
  `stock_mas` int(10) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo_medida` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_catbiendet` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_reflibrodet` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_mas`),
  KEY `tbreferencialibrodettbmaster` (`codigo_reflibrodet`),
  KEY `tbproveedortbmaster` (`codigo_prov`),
  KEY `tbcategoriaproductostbmaster` (`codigo_cat`),
  KEY `tbcategoriabiendettbmaster` (`codigo_catbiendet`),
  KEY `tbmaster_marca_mas_idx` (`marca_mas`),
  FULLTEXT KEY `tbmaster_nombre_mas_ftidx` (`nombre_mas`),
  CONSTRAINT `tbcategoriabiendettbmaster` FOREIGN KEY (`codigo_catbiendet`) REFERENCES `inventariotmp`.`tbcategoriabiendet` (`codigo_catbiendet`),
  CONSTRAINT `tbcategoriaproductostbmaster` FOREIGN KEY (`codigo_cat`) REFERENCES `inventariotmp`.`tbcategoriaproductos` (`codigo_cat`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tbproveedortbmaster` FOREIGN KEY (`codigo_prov`) REFERENCES `inventariotmp`.`tbproveedor` (`codigo_prov`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tbreferencialibrodettbmaster` FOREIGN KEY (`codigo_reflibrodet`) REFERENCES `inventariotmp`.`tbreferencialibrodet` (`codigo_reflibrodet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbmedida`
--

DROP TABLE IF EXISTS `tbmedida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbmedida` (
  `codigo_medida` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_medida` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_subcat` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_medida`),
  UNIQUE KEY `codigo_medida` (`codigo_medida`),
  KEY `tbsubcategoriatbmedida` (`codigo_subcat`),
  CONSTRAINT `tbsubcategoriatbmedida` FOREIGN KEY (`codigo_subcat`) REFERENCES `inventariotmp`.`tbsubcategoria` (`codigo_subcat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbpermisos`
--

DROP TABLE IF EXISTS `tbpermisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbpermisos` (
  `codigo_user` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `factura_per` tinyint(1) NOT NULL,
  `correlativo_per` tinyint(1) NOT NULL,
  `catconsultar_per` tinyint(1) NOT NULL,
  `catmodificar_per` tinyint(1) NOT NULL,
  `prodconsultar_per` tinyint(1) NOT NULL,
  `prodmodificar_per` tinyint(1) NOT NULL,
  `moventrada_per` tinyint(1) NOT NULL,
  `movajuste_per` tinyint(1) NOT NULL,
  `costos_per` tinyint(1) NOT NULL,
  `bodconsultar_per` tinyint(1) NOT NULL,
  `bodmodificar_per` tinyint(1) NOT NULL,
  `bodtraslado_per` tinyint(1) NOT NULL,
  `bodexistencias_per` tinyint(1) NOT NULL,
  `provconsultar_per` tinyint(1) NOT NULL,
  `provmodificar_per` tinyint(1) NOT NULL,
  `userconsultar_per` tinyint(1) NOT NULL,
  `usermodificar_per` tinyint(1) NOT NULL,
  `MDconsultar_per` tinyint(1) NOT NULL,
  `MDmodificar_per` tinyint(1) NOT NULL,
  `empleados_per` tinyint(1) NOT NULL,
  `clientes_per` tinyint(1) NOT NULL,
  `reportes_per` tinyint(1) NOT NULL,
  `empresa_per` tinyint(1) NOT NULL,
  `sucursal_per` tinyint(1) NOT NULL,
  `permisos_per` tinyint(1) NOT NULL,
  `cierres_per` tinyint(1) NOT NULL,
  `backup_per` tinyint(1) NOT NULL,
  PRIMARY KEY (`codigo_user`),
  CONSTRAINT `tbusertbpermisos` FOREIGN KEY (`codigo_user`) REFERENCES `tbuser` (`codigo_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbproveedor`
--

DROP TABLE IF EXISTS `tbproveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbproveedor` (
  `codigo_prov` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_prov` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numreg_prov` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numnit_prov` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_prov` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto_prov` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_prov` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cel_prov` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_prov` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_prov`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbreferencialibrodet`
--

DROP TABLE IF EXISTS `tbreferencialibrodet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbreferencialibrodet` (
  `codigo_reflibrodet` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_reflibrodet` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_reflibrodet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbsubcategoria`
--

DROP TABLE IF EXISTS `tbsubcategoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbsubcategoria` (
  `codigo_subcat` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_subcat` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_cat` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_subcat`),
  KEY `tbcategoriaproductostbsubcategoria` (`codigo_cat`),
  CONSTRAINT `tbcategoriaproductostbsubcategoria` FOREIGN KEY (`codigo_cat`) REFERENCES `tbcategoriaproductos` (`codigo_cat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbsucursales`
--

DROP TABLE IF EXISTS `tbsucursales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbsucursales` (
  `codigo_scr` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_scr` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_scr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_scr` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_scr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbtipomov`
--

DROP TABLE IF EXISTS `tbtipomov`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbtipomov` (
  `codigo_mov` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_mov` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_mov`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbtirajecreditofiscal`
--

DROP TABLE IF EXISTS `tbtirajecreditofiscal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbtirajecreditofiscal` (
  `correlativodesde` int(10) DEFAULT NULL,
  `correlativohasta` int(10) DEFAULT NULL,
  `tirajedesde` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tirajehasta` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ultimocorrelativo` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbtirajefact`
--

DROP TABLE IF EXISTS `tbtirajefact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbtirajefact` (
  `correlativodesde` int(10) DEFAULT NULL,
  `correlativohasta` int(10) DEFAULT NULL,
  `tirajedesde` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tirajehasta` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ultimocorrelativo` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbtrasladosbodegas`
--

DROP TABLE IF EXISTS `tbtrasladosbodegas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbtrasladosbodegas` (
  `codigo_trs` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origen_trs` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destino_trs` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad_trs` int(10) DEFAULT NULL,
  `fecha_trs` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbuser`
--

DROP TABLE IF EXISTS `tbuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbuser` (
  `codigo_user` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_user` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido_user` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rango_user` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_user` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_user` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cel_user` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_user` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario_user` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pass_user` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipocodbod_user` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipocodprov_user` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipocodmas_user` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipocodcat_user` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-01 22:03:42
