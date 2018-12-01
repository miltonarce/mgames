/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50723
Source Host           : localhost:3306
Source Database       : arce_milton_millenialgames

Target Server Type    : MYSQL
Target Server Version : 50723
File Encoding         : 65001

Date: 2018-12-01 16:10:59
*/

SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE IF EXISTS  `mgames`;
CREATE DATABASE `mgames`;
USE `mgames`;

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `idcat` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoria` varchar(45) NOT NULL,
  PRIMARY KEY (`idcat`),
  UNIQUE KEY `idcat_UNIQUE` (`idcat`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of categorias
-- ----------------------------
INSERT INTO `categorias` VALUES ('1', 'Sin Categoría');
INSERT INTO `categorias` VALUES ('2', 'Pc');
INSERT INTO `categorias` VALUES ('3', 'Play Station 4');
INSERT INTO `categorias` VALUES ('4', 'Xbox One');
INSERT INTO `categorias` VALUES ('5', 'Nintendo Switch');
INSERT INTO `categorias` VALUES ('6', '3Ds');

-- ----------------------------
-- Table structure for tipos
-- ----------------------------
DROP TABLE IF EXISTS `tipos`;
CREATE TABLE `tipos` (
  `idtipo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) NOT NULL,
  PRIMARY KEY (`idtipo`),
  UNIQUE KEY `idtipo_UNIQUE` (`idtipo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tipos
-- ----------------------------
INSERT INTO `tipos` VALUES ('1', 'Sin Tipo');
INSERT INTO `tipos` VALUES ('2', 'Consolas');
INSERT INTO `tipos` VALUES ('3', 'Juegos');
INSERT INTO `tipos` VALUES ('4', 'Accesorios');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('1', 'adminmg', '$2y$10$m4hw3R2MIpFUrL2ZgWCNF.8Zl7Jy9LJ4voWfk3jn3NS3XO3z7Ha3W');
INSERT INTO `usuarios` VALUES ('1', 'test', '$2y$10$5MgLxYuAnin5Utu3ygLJieHpWK2GKk9HieJRJPE9BlxOGIm.v.5/W');

-- ----------------------------
-- Table structure for productos
-- ----------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `idproducto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` text,
  `stock` int(10) unsigned DEFAULT '0',
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha_alta` date NOT NULL,
  `img` varchar(255) DEFAULT 'no-image.png',
  `fkidcat` int(10) unsigned NOT NULL,
  `fkidtipo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idproducto`),
  UNIQUE KEY `idproducto_UNIQUE` (`idproducto`),
  KEY `fkidcat_idx` (`fkidcat`),
  KEY `fkidtipo_idx` (`fkidtipo`),
  CONSTRAINT `fkidcat` FOREIGN KEY (`fkidcat`) REFERENCES `categorias` (`idcat`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fkidtipo` FOREIGN KEY (`fkidtipo`) REFERENCES `tipos` (`idtipo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of productos
-- ----------------------------
INSERT INTO `productos` VALUES ('1', 'Play Station 4', 'Consola Play station 4 con 2 mandos de regalo + un juego a elección', '20', '15000.00', '2018-10-06', '1_2018-10-06.jpg', '3', '2');
INSERT INTO `productos` VALUES ('2', 'Fifa 19', 'Juego Fifa 19 para la consola play station 4, standard edition.', '50', '2800.00', '2018-10-06', '2_2018-10-06.jpg', '3', '3');
INSERT INTO `productos` VALUES ('3', 'SpiderMan', 'Juego Spiderman paral a consola Play station 4', '120', '2800.00', '2018-10-07', 'no-image.png', '3', '3');
INSERT INTO `productos` VALUES ('4', 'Red Dead Redemption', 'Juego Red Dead Redemption para la consola Xbox One', '23', '3000.00', '2018-10-07', 'no-image.png', '4', '3');
