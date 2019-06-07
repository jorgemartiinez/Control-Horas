-- phpMyAdmin SQL Dump
-- version 4.1.11
-- http://www.phpmyadmin.net
--
-- Host: vl19749.dinaserver.com
-- Generation Time: 24-04-2019 a les 11:53:57
-- Versió del servidor: 5.5.62-0+deb8u1-log
-- PHP Version: 5.4.45-0+deb7u14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `controlhores_test`
--

-- --------------------------------------------------------
/* BORRAMOS TABLAS SI EXISTEN YA */

DROP TABLE IF EXISTS  `config`;
DROP TABLE IF EXISTS  `horas`;
DROP TABLE IF EXISTS  `imagenes`;
DROP TABLE IF EXISTS  `items`;
DROP TABLE IF EXISTS  `password_reset`;
DROP TABLE IF EXISTS  `users`;

--
-- Estructura de la taula `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clave` varchar(80) NOT NULL,
  `valor` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clave` (`clave`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Bolcant dades de la taula `config`
--

INSERT INTO `config` (`id`, `clave`, `valor`) VALUES
(1, 'logo', ''),
(2, 'footer-direccion', ''),
(3, 'footer-empresa', ''),
(4, 'footer-email', '');

-- --------------------------------------------------------
--
-- Estructura de la taula `horas`
--

CREATE TABLE IF NOT EXISTS `horas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_client` int(10) unsigned NOT NULL,
  `horas` mediumint(9) NOT NULL,
  `data_inici` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_final` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_horas_users` (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;


--
-- Estructura de la taula `imagenes`
--

CREATE TABLE IF NOT EXISTS `imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) unsigned NOT NULL DEFAULT '0',
  `perfil` varchar(150) NOT NULL DEFAULT 'user-default.png',
  `fondo` varchar(150) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_client` (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(180) DEFAULT NULL,
  `descripcio` longtext NOT NULL,
  `id_client` int(10) unsigned NOT NULL,
  `data_inici` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hores` float unsigned NOT NULL DEFAULT '0',
  `data_final` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `caducada` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_items_users` (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;


--
-- Estructura de la taula `password_reset`
--

CREATE TABLE IF NOT EXISTS `password_reset` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_client` int(10) unsigned NOT NULL,
  `token` varchar(255) NOT NULL,
  `expira` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_password_reset_users` (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Estructura de la taula `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` char(50) NOT NULL,
  `rol` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0->customer 1->admin',
  `estado` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '0-> Bloqueado 1->Activado',
  `email` char(100) NOT NULL,
  `data_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- Restriccions per taules bolcades
--

--
-- Restriccions per la taula `horas`
--
ALTER TABLE `horas`
  ADD CONSTRAINT `FK_horas_users` FOREIGN KEY (`id_client`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriccions per la taula `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `FK_imagenes_users` FOREIGN KEY (`id_client`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriccions per la taula `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `FK_items_users` FOREIGN KEY (`id_client`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriccions per la taula `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `FK_password_reset_users` FOREIGN KEY (`id_client`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
