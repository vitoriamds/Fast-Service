-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: FASTSERVICE
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

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
-- Table structure for table `CATEGORIAS`
--

DROP TABLE IF EXISTS `CATEGORIAS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CATEGORIAS` (
  `CTG_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CTG_NOME` varchar(40) NOT NULL,
  PRIMARY KEY (`CTG_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CATEGORIAS`
--

LOCK TABLES `CATEGORIAS` WRITE;
/*!40000 ALTER TABLE `CATEGORIAS` DISABLE KEYS */;
INSERT INTO `CATEGORIAS` VALUES (4,'Moda e beleza'),(7,'Esportes e lazer'),(8,'Culinária'),(10,'Músicas e hobbies');
/*!40000 ALTER TABLE `CATEGORIAS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `COMENTARIOS`
--

DROP TABLE IF EXISTS `COMENTARIOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `COMENTARIOS` (
  `CMT_ID` int(11) NOT NULL,
  `CMT_COMENTARIO` varchar(255) DEFAULT NULL,
  `CMT_USER_ID` int(11) NOT NULL,
  `CMT_SRV_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`CMT_ID`),
  KEY `CMT_USER_ID` (`CMT_USER_ID`),
  KEY `CMT_SRV_ID` (`CMT_SRV_ID`),
  CONSTRAINT `COMENTARIOS_ibfk_1` FOREIGN KEY (`CMT_USER_ID`) REFERENCES `USUARIOS` (`USER_ID`),
  CONSTRAINT `COMENTARIOS_ibfk_2` FOREIGN KEY (`CMT_SRV_ID`) REFERENCES `SERVICOS` (`SRV_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COMENTARIOS`
--

LOCK TABLES `COMENTARIOS` WRITE;
/*!40000 ALTER TABLE `COMENTARIOS` DISABLE KEYS */;
/*!40000 ALTER TABLE `COMENTARIOS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SERVICOS`
--

DROP TABLE IF EXISTS `SERVICOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SERVICOS` (
  `SRV_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SRV_NOME` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SRV_CATEGORIA` int(11) NOT NULL,
  `SRV_DESCRICAO` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SRV_LOCALIZACAO` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `SRV_PRECO` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SRV_USER_ID` int(11) NOT NULL,
  PRIMARY KEY (`SRV_ID`),
  KEY `SRV_CATEGORIA` (`SRV_CATEGORIA`),
  KEY `SRV_USER_ID` (`SRV_USER_ID`),
  CONSTRAINT `SERVICOS_ibfk_1` FOREIGN KEY (`SRV_CATEGORIA`) REFERENCES `CATEGORIAS` (`CTG_ID`),
  CONSTRAINT `SERVICOS_ibfk_2` FOREIGN KEY (`SRV_USER_ID`) REFERENCES `USUARIOS` (`USER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SERVICOS`
--

LOCK TABLES `SERVICOS` WRITE;
/*!40000 ALTER TABLE `SERVICOS` DISABLE KEYS */;
INSERT INTO `SERVICOS` VALUES (4,'Padaria Gourmet',8,'teste','Igarassu, Pe','50',6),(5,'pizza',8,'melhor pizza da regiao','igarassu','10',8),(6,'Instalador de arcondicionado',10,'Muito legal','Igarassu','400',9),(7,'teste',4,'asdda','Igarassu','15',7);
/*!40000 ALTER TABLE `SERVICOS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USUARIOS`
--

DROP TABLE IF EXISTS `USUARIOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `USUARIOS` (
  `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_NOME` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `USER_USUARIO` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `USER_SENHA` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `USER_EMAIL` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `USER_TELEFONE` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`USER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USUARIOS`
--

LOCK TABLES `USUARIOS` WRITE;
/*!40000 ALTER TABLE `USUARIOS` DISABLE KEYS */;
INSERT INTO `USUARIOS` VALUES (6,'Alessandro','Alessandro0325','202cb962ac59075b964b07152d234b70','alessandrosilva325@gmail.com','81992931694'),(7,'SANDRO JOSE DA SILVA','Alessandro','202cb962ac59075b964b07152d234b70','thiagomoura86@live.com','81992931694'),(8,'gabriel','gabrielp','202cb962ac59075b964b07152d234b70','gabrielpessoanascimento@gmail.com','64564564'),(9,'ALEXANDRE STRAPACAO GUEDES VIANNA','alexandre','202cb962ac59075b964b07152d234b70','strapacao@gmail.com','83996992741');
/*!40000 ALTER TABLE `USUARIOS` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-30 14:41:59
