-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 18, 2022 at 04:26 PM
-- Server version: 8.0.27
-- PHP Version: 7.2.34-32+0~20220627.74+debian11~1.gbpc7fa3c

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_infofich2`
--

-- --------------------------------------------------------

--
-- Table structure for table `planif_materias`
--

CREATE TABLE `planif_materias` (
  `id` int NOT NULL,
  `carrera` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `plan` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `version_plan` int NOT NULL,
  `codigo_materia` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `nombre_materia` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tipo_materia` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `hs_semanales` decimal(6,2) DEFAULT NULL,
  `hs_carga_horaria` decimal(6,2) NOT NULL,
  `hs_valor_materia` decimal(6,2) DEFAULT NULL,
  `promediable` tinyint(1) DEFAULT NULL,
  `obligatoria` tinyint(1) NOT NULL,
  `anio_cursada` int NOT NULL,
  `periodo_cursada` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_cursada` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `nro_modulo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `planif_materias`
--

INSERT INTO `planif_materias` (`id`, `carrera`, `plan`, `version_plan`, `codigo_materia`, `nombre_materia`, `tipo_materia`, `hs_semanales`, `hs_carga_horaria`, `hs_valor_materia`, `promediable`, `obligatoria`, `anio_cursada`, `periodo_cursada`, `tipo_cursada`, `nro_modulo`) VALUES
(1, '1073', '032006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1),
(2, '1069', '012006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1),
(6, '1071', '022006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1),
(7, '1077', '082005', 1, 'FICH00056', 'COMUNICACIÓN TÉCNICA - COMUNICACIÓN ELECTRÓNICA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1),
(8, '1073', '032006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ORAL Y ESCRITA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 2),
(9, '1073', '032006', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - SISTEMAS DE REPRESENTACIÓN', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1),
(11, '1073', '032006', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - CAD', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2),
(12, '1069', '012006', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - SISTEMAS DE REPRESENTACIÓN', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1),
(13, '1069', '012006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ORAL Y ESCRITA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 2),
(14, '1069', '012006', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - CAD', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2),
(15, '1071', '022006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ORAL Y ESCRITA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 2),
(16, '1071', '022006', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - SISTEMAS DE REPRESENTACIÓN', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1),
(17, '1071', '022006', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - CAD', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2),
(18, '1077', '082005', 1, 'FICH00056', 'COMUNICACIÓN TÉCNICA - COMUNICACIÓN ORAL Y ESCRITA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 2),
(19, '1077', '082005', 1, 'FICH00056', 'COMUNICACIÓN TÉCNICA - SISTEMAS DE REPRESENTACIÓN', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 3),
(21, '1077', '082005', 1, 'FICH00056', 'COMUNICACIÓN TÉCNICA - CAD', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 4),
(22, '1075', '062007', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1),
(23, '1075', '062007', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ORAL Y ESCRITA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 2),
(24, '1075', '062007', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - SISTEMAS DE REPRESENTACIÓN', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1),
(25, '1075', '062007', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - CAD', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `planif_materias`
--
ALTER TABLE `planif_materias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ak_planif_materias` (`carrera`,`plan`,`version_plan`,`codigo_materia`,`nro_modulo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `planif_materias`
--
ALTER TABLE `planif_materias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
