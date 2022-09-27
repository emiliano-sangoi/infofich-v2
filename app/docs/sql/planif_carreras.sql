-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-09-2022 a las 17:46:08
-- Versión del servidor: 8.0.19-0ubuntu5
-- Versión de PHP: 7.2.34-30+ubuntu20.04.1+deb.sury.org+1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `infofich2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planif_carreras`
--

CREATE TABLE `planif_carreras` (
  `id` int NOT NULL,
  `codigo_carrera` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `nombre_carrera` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `plan_carrera` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `version_plan` int NOT NULL,
  `estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_titulo` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_carrera` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `alcance_titulo` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_actualizacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `planif_carreras`
--

INSERT INTO `planif_carreras` (`id`, `codigo_carrera`, `nombre_carrera`, `plan_carrera`, `version_plan`, `estado`, `tipo_titulo`, `tipo_carrera`, `alcance_titulo`, `fecha_actualizacion`) VALUES
(1, '1069', 'INGENIERÍA AMBIENTAL', '011999', 1, 'A', '1', 'Grado', NULL, '2022-09-23 14:57:11'),
(2, '1069', 'INGENIERÍA AMBIENTAL', '012004', 1, 'A', '1', 'Grado', NULL, '2022-09-23 14:57:11'),
(3, '1069', 'INGENIERÍA AMBIENTAL', '012006', 1, 'V', '1', 'Grado', NULL, '2022-09-23 14:57:11'),
(4, '1071', 'INGENIERÍA EN RECURSOS HÍDRICOS', '021974', 1, 'A', '1', 'Grado', NULL, '2022-09-23 14:57:11'),
(5, '1071', 'INGENIERÍA EN RECURSOS HÍDRICOS', '021992', 1, 'A', '1', 'Grado', NULL, '2022-09-23 14:57:11'),
(6, '1071', 'INGENIERÍA EN RECURSOS HÍDRICOS', '021998', 1, 'A', '1', 'Grado', NULL, '2022-09-23 14:57:11'),
(7, '1071', 'INGENIERÍA EN RECURSOS HÍDRICOS', '021999', 1, 'A', '1', 'Grado', NULL, '2022-09-23 14:57:11'),
(8, '1071', 'INGENIERÍA EN RECURSOS HÍDRICOS', '022004', 1, 'A', '1', 'Grado', NULL, '2022-09-23 14:57:11'),
(9, '1071', 'INGENIERÍA EN RECURSOS HÍDRICOS', '022006', 1, 'V', '1', 'Grado', NULL, '2022-09-23 14:57:11'),
(10, '1073', 'INGENIERÍA EN INFORMÁTICA', '031999', 1, 'A', '1', 'Grado', NULL, '2022-09-23 14:57:11'),
(11, '1073', 'INGENIERÍA EN INFORMÁTICA', '032006', 1, 'V', '1', 'Grado', NULL, '2022-09-23 14:57:11'),
(12, '1074', 'LICENCIATURA EN CARTOGRAFÍA', '051999', 1, 'A', '1', 'Grado', NULL, '2022-09-23 14:57:11'),
(13, '1074', 'LICENCIATURA EN CARTOGRAFÍA', '052002', 1, 'V', '1', 'Grado', NULL, '2022-09-23 14:57:12'),
(14, '1075', 'PERITO TOPO-CARTÓGRAFO', '061974', 1, 'A', '1', 'Pregrado', NULL, '2022-09-23 14:57:12'),
(15, '1075', 'PERITO TOPO-CARTÓGRAFO', '061999', 1, 'A', '1', 'Pregrado', NULL, '2022-09-23 14:57:12'),
(16, '1075', 'PERITO TOPO-CARTÓGRAFO', '062007', 1, 'V', '1', 'Pregrado', NULL, '2022-09-23 14:57:12'),
(17, '1076', 'ANALISTA EN INFORMÁTICA APLICADA', '041993', 1, 'A', '1', 'Pregrado', NULL, '2022-09-23 14:57:12'),
(18, '1076', 'ANALISTA EN INFORMÁTICA APLICADA', '041995', 1, 'A', '1', 'Pregrado', NULL, '2022-09-23 14:57:12'),
(19, '1076', 'ANALISTA EN INFORMÁTICA APLICADA', '041999', 1, 'V', '1', 'Pregrado', NULL, '2022-09-23 14:57:12'),
(20, '1077', 'INGENIERÍA EN AGRIMENSURA', '082004', 1, 'A', '1', 'Grado', NULL, '2022-09-23 14:57:12'),
(21, '1077', 'INGENIERÍA EN AGRIMENSURA', '082005', 1, 'V', '1', 'Grado', NULL, '2022-09-23 14:57:12'),
(22, '1078', 'TECNICATURA UNIVERSITARIA EN AUTOMATIZACIÓN Y ROBÓTICA', '142019', 1, 'V', '1', 'Pregrado', NULL, '2022-09-23 14:57:12'),
(23, '1079', 'HIDROMETRA PLAN II', '071989', 1, 'V', '1', 'Pregrado', NULL, '2022-09-23 14:57:12');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `planif_carreras`
--
ALTER TABLE `planif_carreras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk1_planif_carreras` (`codigo_carrera`,`plan_carrera`,`version_plan`,`estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `planif_carreras`
--
ALTER TABLE `planif_carreras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
