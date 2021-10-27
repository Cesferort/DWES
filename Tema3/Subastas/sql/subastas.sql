-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-10-2021 a las 10:38:11
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `subastas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `categoria`) VALUES
(1, 'Cine'),
(2, 'Joyería'),
(3, 'Mierda'),
(4, 'Videojuegos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

DROP TABLE IF EXISTS `imagen`;
CREATE TABLE IF NOT EXISTS `imagen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) NOT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_item` (`id_item`),
  KEY `id_item_2` (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`id`, `id_item`, `imagen`) VALUES
(1, 57, 'blood_machines.jpg'),
(2, 57, 'blood_machines2.jpg'),
(4, 60, 'estrella_rosa.jpg'),
(5, 62, 'hotline_miami_collection.jpg'),
(6, 59, 'insignia_KGB.jpg'),
(7, 61, 'russia_battlegrounds.jpg'),
(8, 58, 'snatch.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cat` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `preciopartida` float NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `fechafin` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cat` (`id_cat`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `item`
--

INSERT INTO `item` (`id`, `id_cat`, `id_user`, `nombre`, `preciopartida`, `descripcion`, `fechafin`) VALUES
(57, 1, 1, 'Blood Machines', 4.2, 'An artificial intelligence escapes her spaceship to turn into a female ghost and challenges two blade runners to a galactic chase.', '2021-11-30 09:20:11'),
(58, 1, 4, 'Snatch', 52, 'Snatch (stylized as snatch.) is a 2000 British-American crime comedy film written and directed by Guy Ritchie, featuring an ensemble cast.', '2021-11-30 09:20:11'),
(59, 2, 3, 'Insignia de Oro soviética de la KGB', 250, 'It is Excellent Gift For Anyone Who Loves WW1/WW2 era or For Collectors.', '2021-11-30 09:25:43'),
(60, 2, 7, 'Estrella Rosa', 60000000, 'The Pink Star, formerly known as the Steinmetz Pink,[1] is a diamond weighing 59.60 carat (11.92 g), rated in color as Fancy Vivid Pink by the Gemological Institute of America.', '2021-10-26 09:28:36'),
(61, 4, 3, 'Russia Battlegrounds', 2, 'RUSSIA BATTLEGROUNDS is a multiplayer battle royale shooter and your trip to hell. Here start\'s battle of unarmed prisoners, in which the strongest wins.', '2021-11-30 09:34:21'),
(62, 4, 1, 'Hotline Miami Collection', 15, 'Hotline Miami Collection contains both legendary games in the neon-soaked, brutally-challenging Hotline Miami series from Dennaton Games.', '2021-11-30 09:35:25'),
(63, 3, 1, 'Esta Mierda de Ejercicio', 1, '50% PHP + 50% HTML = 100% Mierda', '2021-11-30 10:12:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puja`
--

DROP TABLE IF EXISTS `puja`;
CREATE TABLE IF NOT EXISTS `puja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_item` (`id_item`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `puja`
--

INSERT INTO `puja` (`id`, `id_item`, `id_user`, `cantidad`, `fecha`) VALUES
(1, 63, 6, 2, '2021-10-26'),
(2, 60, 4, 61000000, '2021-10-26'),
(3, 58, 6, 53, '2021-10-27'),
(4, 58, 7, 54, '2021-10-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `cadenaverificacion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `activo` tinyint(4) NOT NULL,
  `falso` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `nombre`, `password`, `email`, `cadenaverificacion`, `activo`, `falso`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@jajasaludos.com', '', 1, 1),
(2, 'Elver Galarga', 'Nelson Ferreira', 'Elver_Galarga1234', 'elvergalarga@jajasaludos.com', '', 1, 1),
(3, 'Stalin Dalavida', 'Aketza Egusquiza', 'Stalin_Dalavida1234', 'stalindalavida@jajasaludos.com', '', 1, 1),
(4, 'Shark-minded Entrepreneur', 'Javier Díaz', 'Shark_Entrepreneur1234', 'sharkentrepreneur@jajasaludos.com', '', 1, 1),
(5, 'Graphic Design is My Passion', 'Tania Alcudia', 'Graphic_Designer1234', 'graphicdesigner@jajasaludos.com', '', 1, 1),
(6, 'Valquiria Chiquita', 'Patricia Bastida', 'Valquiria_Chiquita1234', 'valquiriachiquita@jajasaludos.com', '', 1, 1),
(7, 'Valquiria Basada', 'Marta Bastida', 'Valquiria_Basada1234', 'valquiriabasada@jajasaludos.com', '', 1, 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `CA_IMAGEN_ITEM` FOREIGN KEY (`id_item`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `CA_ITEM_CATEGORIA` FOREIGN KEY (`id_cat`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `CA_ITEM_USUARIO` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `puja`
--
ALTER TABLE `puja`
  ADD CONSTRAINT `CA_PUJA_ITEM` FOREIGN KEY (`id_item`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `CA_PUJA_USUARIO` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;