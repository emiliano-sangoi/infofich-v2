update planif_asignaturas set es_recursada = recursantes;
update planif_asignaturas set es_recursada = 0 where es_recursada IS NULL;

-- Correcciones en asignaturas recursantes:
-- Ing Inf. -> Se cambia el ID 10 (ing inf plan 1999) por ID 11 (ing inf plan 2006):
update planif_asignaturas set carrera_id = 11 where carrera_id = 10;

-- Se borra aquellas vinculadas a ANALISTA EN INFORMATICA
-- ID DE ANALISTA EN INFORMATICA ERA PARA ING AGRIMENSURA
update planif_asignaturas set carrera_id = 21 where carrera_id = 17;


-- IRH -> Se cambia el ID 8 (plan 022004) por ID 9 (plan 2006):
update planif_asignaturas set carrera_id = 9 where carrera_id = 8;