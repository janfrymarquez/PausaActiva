-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: pausaactiva
-- ------------------------------------------------------
-- Server version	5.5.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_departamentos`
--

DROP TABLE IF EXISTS `tbl_departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_departamentos` (
  `IdDepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `Departamento` varchar(45) NOT NULL,
  `CreadoPorUsuarioId` int(11) DEFAULT NULL,
  `ModificadoPorUsuarioId` int(11) DEFAULT NULL,
  `FechaCreacion` date DEFAULT NULL,
  `FechaModificacion` date DEFAULT NULL,
  `Activo` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`IdDepartamento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_departamentos`
--

LOCK TABLES `tbl_departamentos` WRITE;
/*!40000 ALTER TABLE `tbl_departamentos` DISABLE KEYS */;
INSERT INTO `tbl_departamentos` VALUES (1,'Tecnologia',1,1,'2017-09-02',NULL,1),(2,'Gestion Humana',1,1,'2017-09-04',NULL,1);
/*!40000 ALTER TABLE `tbl_departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_empleados`
--

DROP TABLE IF EXISTS `tbl_empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_empleados` (
  `IdEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) NOT NULL,
  `Apellido` varchar(45) NOT NULL,
  `FechaNacimiento` date DEFAULT NULL,
  `FechaIngreso` date DEFAULT NULL,
  `UsuarioRed` varchar(45) NOT NULL,
  `IdDepartamento` int(11) NOT NULL,
  `CreadoPorUsuarioId` int(11) DEFAULT NULL,
  `ModificadoPorUsuarioId` int(11) DEFAULT NULL,
  `FechaCreacion` date DEFAULT NULL,
  `FechaModificacion` date DEFAULT NULL,
  `Activo` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`IdEmpleado`),
  KEY `EnpleadoDepartamento_idx` (`IdDepartamento`),
  CONSTRAINT `EnpleadoDepartamento` FOREIGN KEY (`IdDepartamento`) REFERENCES `tbl_departamentos` (`IdDepartamento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_empleados`
--

LOCK TABLES `tbl_empleados` WRITE;
/*!40000 ALTER TABLE `tbl_empleados` DISABLE KEYS */;
INSERT INTO `tbl_empleados` VALUES (1,'janfry','marquez','1995-02-01','2015-08-10','hbjjmarquez',1,1,1,'2017-09-02','2017-09-02',1),(5,'FAUSTO AMBIORIS','SANCHEZ GARCIA','1975-09-20','1997-08-09','hbfsanchez',1,NULL,NULL,'2017-09-04',NULL,1),(6,'SERVIO EMIL','Ramirez','1970-06-05','2000-03-06','hberamirez',1,1,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `tbl_empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_estadisticas`
--

DROP TABLE IF EXISTS `tbl_estadisticas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_estadisticas` (
  `IdEstadistica` int(11) NOT NULL,
  `CantidadEjecucion` int(11) DEFAULT NULL,
  `CantidadPospuesta` int(11) DEFAULT NULL,
  `Fecha` datetime DEFAULT NULL,
  `IdDepartamento` int(11) DEFAULT NULL,
  `IdEmpleado` int(11) DEFAULT NULL,
  `tbl_estadisticascol` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdEstadistica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_estadisticas`
--

LOCK TABLES `tbl_estadisticas` WRITE;
/*!40000 ALTER TABLE `tbl_estadisticas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_estadisticas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pausa_activa`
--

DROP TABLE IF EXISTS `tbl_pausa_activa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pausa_activa` (
  `IdPausaActiva` int(11) NOT NULL,
  `IdDepartamento` int(11) NOT NULL,
  `IdVideo` int(11) NOT NULL,
  `Dias` varchar(15) NOT NULL,
  `HoraEjecucion` time NOT NULL,
  `Tanda` int(11) NOT NULL,
  `Semana` int(11) DEFAULT NULL,
  `CreadoPorUsuarioId` int(11) DEFAULT NULL,
  `ModificadoPorUsuarioId` int(11) DEFAULT NULL,
  `FechaCreacion` date DEFAULT NULL,
  `FechaModificacion` date DEFAULT NULL,
  `activo` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`IdPausaActiva`),
  KEY `Departamento_idx` (`IdDepartamento`),
  KEY `Video_idx` (`IdVideo`),
  CONSTRAINT `Departamento` FOREIGN KEY (`IdDepartamento`) REFERENCES `tbl_departamentos` (`IdDepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Video` FOREIGN KEY (`IdVideo`) REFERENCES `tbl_video` (`IdVideo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pausa_activa`
--

LOCK TABLES `tbl_pausa_activa` WRITE;
/*!40000 ALTER TABLE `tbl_pausa_activa` DISABLE KEYS */;
INSERT INTO `tbl_pausa_activa` VALUES (1,1,1,'martes','14:26:50',1,1,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `tbl_pausa_activa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_tipo_entrenamientos`
--

DROP TABLE IF EXISTS `tbl_tipo_entrenamientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tipo_entrenamientos` (
  `IdEntrenamiento` int(11) NOT NULL AUTO_INCREMENT,
  `TipoEntrenamiento` varchar(45) NOT NULL,
  `CreadoPorUsuarioId` int(11) DEFAULT NULL,
  `ModificadoPorUsuarioId` int(11) DEFAULT NULL,
  `FechaCreacion` date DEFAULT NULL,
  `FechaModificacion` date DEFAULT NULL,
  `activo` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`IdEntrenamiento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tipo_entrenamientos`
--

LOCK TABLES `tbl_tipo_entrenamientos` WRITE;
/*!40000 ALTER TABLE `tbl_tipo_entrenamientos` DISABLE KEYS */;
INSERT INTO `tbl_tipo_entrenamientos` VALUES (1,'Hombro',NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `tbl_tipo_entrenamientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_users` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `PrimerNombre` varchar(45) NOT NULL,
  `Apellido` varchar(45) NOT NULL,
  `Foto` varchar(45) DEFAULT NULL,
  `CreadoPorUsuarioId` int(11) NOT NULL,
  `ModificadoPorUsuarioId` int(11) NOT NULL,
  `FechaCreacion` date NOT NULL,
  `FechaModificacion` date NOT NULL,
  `activo` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_users`
--

LOCK TABLES `tbl_users` WRITE;
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_video`
--

DROP TABLE IF EXISTS `tbl_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_video` (
  `IdVideo` int(11) NOT NULL,
  `UrlVideo` text NOT NULL,
  `IdEntrenamiento` int(11) NOT NULL,
  `CreadoPorUsuarioId` int(11) DEFAULT NULL,
  `ModificadoPorUsuarioId` int(11) DEFAULT NULL,
  `FechaCreacion` date DEFAULT NULL,
  `FechaModificacion` date DEFAULT NULL,
  `activo` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`IdVideo`),
  KEY `VideoTipoEntrenamiento_idx` (`IdEntrenamiento`),
  CONSTRAINT `VideoTipoEntrenamiento` FOREIGN KEY (`IdEntrenamiento`) REFERENCES `tbl_tipo_entrenamientos` (`IdEntrenamiento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_video`
--

LOCK TABLES `tbl_video` WRITE;
/*!40000 ALTER TABLE `tbl_video` DISABLE KEYS */;
INSERT INTO `tbl_video` VALUES (1,'C:\\Users\\hbjjmarquez\\Videos\\video.mp4',1,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `tbl_video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `vw_pausa_activa`
--

DROP TABLE IF EXISTS `vw_pausa_activa`;
/*!50001 DROP VIEW IF EXISTS `vw_pausa_activa`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vw_pausa_activa` AS SELECT 
 1 AS `IdPausaActiva`,
 1 AS `IdDepartamento`,
 1 AS `Dias`,
 1 AS `HoraEjecucion`,
 1 AS `Tanda`,
 1 AS `Semana`,
 1 AS `Departamento`,
 1 AS `UrlVideo`,
 1 AS `UsuarioRed`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'pausaactiva'
--

--
-- Final view structure for view `vw_pausa_activa`
--

/*!50001 DROP VIEW IF EXISTS `vw_pausa_activa`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_pausa_activa` AS select `pa`.`IdPausaActiva` AS `IdPausaActiva`,`dep`.`IdDepartamento` AS `IdDepartamento`,`pa`.`Dias` AS `Dias`,`pa`.`HoraEjecucion` AS `HoraEjecucion`,`pa`.`Tanda` AS `Tanda`,`pa`.`Semana` AS `Semana`,`dep`.`Departamento` AS `Departamento`,`video`.`UrlVideo` AS `UrlVideo`,`emp`.`UsuarioRed` AS `UsuarioRed` from (((`tbl_pausa_activa` `pa` join `tbl_departamentos` `dep` on((`pa`.`IdDepartamento` = `dep`.`IdDepartamento`))) join `tbl_video` `video` on((`pa`.`IdVideo` = `video`.`IdVideo`))) join `tbl_empleados` `emp` on((`dep`.`IdDepartamento` = `emp`.`IdDepartamento`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-18 13:16:57
