-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 18, 2022 at 04:26 PM
-- Server version: 8.0.27
-- PHP Version: 7.2.34-32+0~20220627.74+debian11~1.gbpc7fa3c


ALTER TABLE `planif_materias` ADD `recursantes` INT(11) NULL DEFAULT NULL ;

--
-- Dumping data for table `planif_materias`
--

INSERT INTO `planif_materias` (`id`, `carrera`, `plan`, `version_plan`, `codigo_materia`, `nombre_materia`, `tipo_materia`, `hs_semanales`, `hs_carga_horaria`, `hs_valor_materia`, `promediable`, `obligatoria`, `anio_cursada`, `periodo_cursada`, `tipo_cursada`, `nro_modulo`) VALUES
(NULL, '1073', '032006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1);
/*(2, '1069', '012006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1),
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
(25, '1075', '062007', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - CAD', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2);*/