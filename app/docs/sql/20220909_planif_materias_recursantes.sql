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
--1073 - II - 032006 1 -> carrera_id 10
--1069 - IA - 012006, 1 -> carrera_id 3
--1071 - IRG - 022006, 1 -> carrera_id 8
--1077 - IAgrimensura, -> carrera_id 17
INSERT INTO `planif_asignaturas` 
(`id`, `carrera_id`, `codigo_asignatura` ,`nombre_asignatura`, `tipo_asignatura`, `hs_semanales`, `hs_carga_horaria`, `hs_valor_asignatura`, `promediable`, `obligatoria`, `anio_cursada`, `periodo_cursada`, `tipo_cursada`, `nro_modulo`,  `recursantes`,`origen_ws`,`fecha_actualizacion`) VALUES
(NULL,10, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1,1, false, NOW()),

(NULL, 3, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1,1, false, NOW()),
(NULL, 8, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1,1, false, NOW()),
(NULL, 17,'FICH00056', 'COMUNICACIÓN TÉCNICA - COMUNICACIÓN ELECTRÓNICA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1,1, false, NOW()),

(NULL, 10,'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ORAL Y ESCRITA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 2,1, false, NOW()),
(NULL, 3, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ORAL Y ESCRITA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2,1, false, NOW()),
(NULL, 8, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ORAL Y ESCRITA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2, 1, false, NOW()),
(NULL, 17,'FICH00056', 'COMUNICACIÓN TÉCNICA - COMUNICACIÓN ORAL Y ESCRITA (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2, 1, false, NOW()),

(NULL, 10,'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - SISTEMAS DE REPRESENTACIÓN (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1,1, false, NOW()),
(NULL, 3, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - SISTEMAS DE REPRESENTACIÓN (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1, 1, false, NOW()),
(NULL, 8, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - SISTEMAS DE REPRESENTACIÓN (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1,1, false, NOW()),
(NULL, 17,'FICH00056', 'COMUNICACIÓN TÉCNICA - SISTEMAS DE REPRESENTACIÓN (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 3,1, false, NOW()),

(NULL, 10,'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - CAD (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2,1, false, NOW()),
(NULL, 3, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - CAD (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 2,1, false, NOW()),
(NULL, 8, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - CAD (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 2, 1, false, NOW()),
(NULL, 17,'FICH00056', 'COMUNICACIÓN TÉCNICA - CAD (RECURSANTES)', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 4,1, false, NOW()),

-- Para Ingeniería Ambiental:  Matemática Básica (Recursantes) y Química General e Inorgánica (Recursantes)
(NULL, 3,'FICHIRH01', 'MATEMÁTICA BÁSICA (RECURSANTES)', 'N', NULL, '90.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1, false, NOW()),
(NULL, 3,'FHUCBIO03', 'QUÍMICA GENERAL E INORGÁNICA (RECURSANTES)', 'N', NULL, '105.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1, false, NOW()),


-- Para Ingeniería en Agrimensura: Matemática Básica (Recursantes) y Química General (Recursantes) 
(NULL, 17, 'FICHIRH01', 'MATEMÁTICA BÁSICA (RECURSANTES)', 'N', NULL, '90.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1, false, NOW()),
(NULL, 17, 'FICHIF003', 'QUÍMICA GENERAL (RECURSANTES)', 'N', NULL, '60.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1, false, NOW()),

-- Para Ingeniería en Informática: Matemática Básica (Recursantes) - Química General (Recursantes) - Fundamentos de Programación (Recursantes) 
(NULL, 10,'FICHIRH01', 'MATEMÁTICA BÁSICA (RECURSANTES)', 'N', NULL, '90.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1, false, NOW()),
(NULL, 10,'FICHIF003', 'QUÍMICA GENERAL (RECURSANTES)', 'N', NULL, '60.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1, false, NOW()),
(NULL, 10,'FHUCMAT11', 'FUNDAMENTOS DE PROGRAMACIÓN (RECURSANTES)', 'N', NULL, '90.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1, false, NOW()),

-- Para Ingeniería en Recursos Hídricos: Matemática Básica (Recursantes)  y Química General e Inorgánica (Recursantes) 
(NULL, 8, 'FICHIRH01', 'MATEMÁTICA BÁSICA (RECURSANTES)', 'N', NULL, '90.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1, false, NOW()),
(NULL, 8, 'FHUCBIO03', 'QUÍMICA GENERAL E INORGÁNICA (RECURSANTES)', 'N', NULL, '105.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', NULL,1, false, NOW()),



/*
(22, '1075', '062007', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ELECTRÓNICA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 1),
(23, '1075', '062007', 1, 'FICHIRH03', 'COMUNICACIÓN TÉCNICA I - COMUNICACIÓN ORAL Y ESCRITA', 'N', NULL, '30.00', NULL, 1, 1, 1, '2do Cuatrimestre', 'cuatrimestre', 2),
(24, '1075', '062007', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - SISTEMAS DE REPRESENTACIÓN', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 1),
(25, '1075', '062007', 1, 'FICHIRH06', 'COMUNICACIÓN TÉCNICA II - CAD', 'N', NULL, '30.00', NULL, 1, 1, 1, '1er Cuatrimestre', 'cuatrimestre', 2);*/