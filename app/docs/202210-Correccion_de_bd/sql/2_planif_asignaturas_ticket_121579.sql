-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 18, 2022 at 04:26 PM
-- Server version: 8.0.27
-- PHP Version: 7.2.34-32+0~20220627.74+debian11~1.gbpc7fa3c


--
-- Dumping data for table `planif_materias`
--

INSERT INTO `planif_asignaturas` 
(`id`, `carrera_id`, `codigo_asignatura`, `nombre_asignatura`, `tipo_asignatura`, `hs_semanales`, `hs_carga_horaria`, `hs_valor_asignatura`, `promediable`, `obligatoria`, `anio_cursada`, `periodo_cursada`, `tipo_cursada`, `nro_modulo`, `es_recursada`,`origen_ws`,`fecha_actualizacion`) VALUES
(NULL, 11, 'FICHIF036','GESTIÓN DE EMPRESAS','N', '4', '60.00', '6', 1, 1, 5, '2do Cuatrimestre', 'cuatrimestre', NULL, 0, false, NOW()),

(NULL, 11, 'FICHIF024','CIENCIA, TECNOLOGÍA y SOCIEDAD','N', '5', '75.00', '6', 1, 1, 3, '2do Cuatrimestre', 'cuatrimestre', NULL, 0, false, NOW()),

(NULL, 3, 'FCA10017','ECOLOGÍA','N', '6', '90.00', '6', 1, 1, 3, '2do Cuatrimestre', 'cuatrimestre', NULL, 0, false, NOW())