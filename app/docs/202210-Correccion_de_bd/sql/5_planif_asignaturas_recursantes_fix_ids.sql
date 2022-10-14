update planif_asignaturas set es_recursada = recursantes;
update planif_asignaturas set es_recursada = 0 where es_recursada IS NULL;

-- Correcciones en asignaturas recursantes:
-- Ing Inf. -> Se cambia el ID 10 (ing inf plan 1999) por ID 11 (ing inf plan 2006):
update planif_asignaturas set carrera_id = 11 where carrera_id = 10;

-- Se borra aquellas vinculadas a ANALISTA EN INFORMATICA
delete from planif_asignaturas where carrera_id = 17;

-- IRH -> Se cambia el ID 8 (plan 022004) por ID 9 (plan 2006):
update planif_asignaturas set carrera_id = 9 where carrera_id = 8;

INSERT INTO `planif_asignaturas`
(`id`, `carrera_id`, `codigo_asignatura` , `nombre_asignatura`,
 `tipo_asignatura`, `hs_semanales`, `hs_carga_horaria`, `hs_valor_asignatura`,
 `promediable`, `obligatoria`, `anio_cursada`, `periodo_cursada`,
 `tipo_cursada`, `nro_modulo`,  `es_recursada`, `origen_ws`,`fecha_actualizacion`)
VALUES
(NULL, 21, 'FICHIRH01', 'MATEMÁTICA BÁSICA (RECURSANTES)',
 'N', NULL, '90.00', NULL,
 1, 1, 1, '2do Cuatrimestre',
 'cuatrimestre', NULL,1, false, NOW()),
(NULL, 21, 'FICHIF003', 'QUÍMICA GENERAL (RECURSANTES)',
 'N', NULL, '60.00', NULL,
 1, 1, 1, '2do Cuatrimestre',
 'cuatrimestre', NULL, 1, false, NOW());

delete from planif_asignaturas
where carrera_id = 11 and
        id in (795, 856, 845, 855, 829, 858, 807, 962, 821, 812, 811, 810, 846, 834, 841, 826, 796, 847, 824, 825, 806, 808, 929, 859, 853, 863, 822, 816,848, 849,813, 850, 836, 887, 891, 814, 823, 854, 862 );
