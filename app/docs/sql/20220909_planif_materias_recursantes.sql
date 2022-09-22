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
--1073 - II
--1069 - IA
--1071 - IRG
--1077 - IAgrimensura
INSERT INTO `planif_materias` (`id`, `carrera`, `plan`, `version_plan`, `codigo_materia`, `nombre_materia`, `tipo_materia`, `hs_semanales`, `hs_carga_horaria`, `hs_valor_materia`, `promediable`, `obligatoria`, `anio_cursada`, `periodo_cursada`, `tipo_cursada`, `nro_modulo`,  `recursantes`) VALUES
(NULL, '1073', '032006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1,1),
(NULL, '1069', '012006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1,1),
(NULL, '1071', '022006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1,1),
(NULL, '1077', '082005', 1, 'FICH00056', 'COMUNICACIÓN TÉCNICA - COMUNICACIÓN ELECTRÓNICA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1,1),

(NULL, '1073', '032006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ORAL Y ESCRITA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2,1),
(NULL, '1069', '012006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ORAL Y ESCRITA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2,1),
(NULL, '1071', '022006', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ORAL Y ESCRITA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2, 1),
(NULL, '1077', '082005', 1, 'FICH00056', 'COMUNICACIÓN TÉCNICA - COMUNICACIÓN ORAL Y ESCRITA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2, 1),

(NULL, '1073', '032006', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - SISTEMAS DE REPRESENTACIÓN (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1,1),
(NULL, '1069', '012006', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - SISTEMAS DE REPRESENTACIÓN (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1, 1),
(NULL, '1071', '022006', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - SISTEMAS DE REPRESENTACIÓN (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1,1),
(NULL, '1077', '082005', 1, 'FICH00056', 'COMUNICACIÓN TÉCNICA - SISTEMAS DE REPRESENTACIÓN (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 3,1),

(NULL, '1073', '032006', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - CAD (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 2,1),
(NULL, '1069', '012006', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - CAD (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 2,1),
(NULL, '1071', '022006', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - CAD (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 2, 1),
(NULL, '1077', '082005', 1, 'FICH00056', 'COMUNICACIÓN TÉCNICA - CAD (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 4,1),

-- Para Ingeniería Ambiental:  Matemática Básica (Recursantes) y Química General e Inorgánica (Recursantes)
(NULL, '1069', '012006', 1, 'FICHIRH01', 'MATEMÁTICA BÁSICA (RECURSANTES)', 'N', NULL, '90.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1),
(NULL, '1069', '012006', 1, 'FHUCBIO03', 'QUÍMICA GENERAL E INORGÁNICA (RECURSANTES)', 'N', NULL, '105.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1),


-- Para Ingeniería en Agrimensura: Matemática Básica (Recursantes) y Química General (Recursantes) 
(NULL, '1077', '082005', 1, 'FICHIRH01', 'MATEMÁTICA BÁSICA (RECURSANTES)', 'N', NULL, '90.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', NULL,1),
(NULL, '1077', '082005', 1, 'FICHIF003', 'QUÍMICA GENERAL (RECURSANTES)', 'N', NULL, '60.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1),

-- Para Ingeniería en Informática: Matemática Básica (Recursantes) - Química General (Recursantes) - Fundamentos de Programación (Recursantes) 
(NULL, '1073', '032006', 1, 'FICHIRH01', 'MATEMÁTICA BÁSICA (RECURSANTES)', 'N', NULL, '90.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1),
(NULL, '1073', '032006', 1, 'FICHIF003', 'QUÍMICA GENERAL (RECURSANTES)', 'N', NULL, '60.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1),
(NULL, '1073', '032006', 1, 'FHUCMAT11', 'FUNDAMENTOS DE PROGRAMACIÓN (RECURSANTES)', 'N', NULL, '90.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1),

-- Para Ingeniería en Recursos Hídricos: Matemática Básica (Recursantes)  y Química General e Inorgánica (Recursantes) 
(NULL, '1071', '022006', 1, 'FICHIRH01', 'MATEMÁTICA BÁSICA (RECURSANTES)', 'N', NULL, '90.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1),
(NULL, '1071', '022006', 1, 'FHUCBIO03', 'QUÍMICA GENERAL E INORGÁNICA (RECURSANTES)', 'N', NULL, '105.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1);



/*
(22, '1075', '062007', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1),
(23, '1075', '062007', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ORAL Y ESCRITA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 2),
(24, '1075', '062007', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - SISTEMAS DE REPRESENTACIÓN', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1),
(25, '1075', '062007', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - CAD', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2);*/