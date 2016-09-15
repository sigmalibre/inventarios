-- MySQL dump 10.15  Distrib 10.0.25-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: inventarios
-- ------------------------------------------------------
-- Server version	10.0.25-MariaDB-0ubuntu0.16.04.1

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
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id_producto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo_producto` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca_producto` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo_producto` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_producto` text COLLATE utf8mb4_unicode_ci,
  `cantidad_producto` int(11) NOT NULL DEFAULT '0',
  `ubicacion_producto` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_producto`),
  UNIQUE KEY `uniq_codigo_producto` (`codigo_producto`),
  KEY `idx_marca_producto` (`marca_producto`),
  KEY `idx_modelo_producto` (`modelo_producto`),
  FULLTEXT KEY `ft_descripcion_producto` (`descripcion_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'282055120329','DEWALT','DCS391B','DEWALT DCS391B 20V Max Li-Ion 6-1/2in Inalámbrico Sierra Circular (Herramienta Solamente)',5,'Casa Matriz'),(2,'610055843','Stanley','STRR1200','Fresadora Router Rebajador Stanley 1200w Profesional + fresas',3,'Casa Matriz'),(3,'621567129','Omaha','WRS-15/90-Z','Bomba Presurizadora Elevadora De Presion Omaha',5,'Sucursal San Salvador'),(4,'545255455','Pretul','24223','Juego De Herramientas 133 Piezas Con Estuche Pretul 24223',2,'Sucursal San Salvador'),(5,'551046997','Oakland','MD-52 G','Martillo Demoledor Gasolina Oakland (rompedor Gasolina)',1,'Casa Matriz');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-13  3:59:36
