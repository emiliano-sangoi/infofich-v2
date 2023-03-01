-- Actualizacion de la tabla planif_carreras
-- Por cambios en los web services de rectorado, el formato del plan de la carrera pasa de 6 digitos a 4

-- Luego de ejecutar schema:update el primer paso es guarda el codigo actual de cada plan en una nueva columna
update planif_carreras set plan_carrera_ant = plan_carrera;

-- Ingenieria Ambiental (1069)
-- =========================================================================
-- 11999 -> 1121
update planif_carreras set plan_carrera = 1121 where id = 1;
-- 12004 -> 1122
update planif_carreras set plan_carrera = 1122 where id = 2;
-- 12006 -> 1123
update planif_carreras set plan_carrera = 1123 where id = 3;

-- Ingenieria en Recursos Hidricos (1071)
-- =========================================================================
-- 21974 ->	1140
update planif_carreras set plan_carrera = 1140 where id = 4;
-- 21992 -> 1141
update planif_carreras set plan_carrera = 1141 where id = 5;
-- 21998 -> 1124
update planif_carreras set plan_carrera = 1124 where id = 6;
-- 21999 -> 1125
update planif_carreras set plan_carrera = 1125 where id = 7;
-- 22004 -> 1126
update planif_carreras set plan_carrera = 1126 where id = 8;
-- 22006 -> 1127
update planif_carreras set plan_carrera = 1127 where id = 9;

-- Ingenieria en Informatica (1073)
-- =========================================================================
-- 31999 -> 1128
update planif_carreras set plan_carrera = 1128 where id = 10;
-- 32006 -> 1129
update planif_carreras set plan_carrera = 1129 where id = 11;

-- Licenciatura en Cartografía (1074)
-- =========================================================================
-- 51999 -> 1131
update planif_carreras set plan_carrera = 1131 where id = 12;
-- 52002 -> 1132
update planif_carreras set plan_carrera = 1132 where id = 13;

-- Perito topocartografo (1075)
-- =========================================================================
-- 61974 -> 1133
update planif_carreras set plan_carrera = 1133 where id = 14;
-- 61999 -> 1134
update planif_carreras set plan_carrera = 1134 where id = 15;
-- 62007 -> 1135
update planif_carreras set plan_carrera = 1135 where id = 16;

-- Analista en Informatica (1076)
-- =========================================================================
-- 41993 -> 1142
update planif_carreras set plan_carrera = 1142 where id = 17;
-- 41995 -> 1143
update planif_carreras set plan_carrera = 1143 where id = 18;
-- 41999 -> 1130
update planif_carreras set plan_carrera = 1130 where id = 19;

-- Ingenieria en Agrimensura (1077)
-- =========================================================================
-- 82004 -> 1136
update planif_carreras set plan_carrera = 1136 where id = 20;
-- 82005 -> 1137
update planif_carreras set plan_carrera = 1137 where id = 21;

-- Tecnicatura universitaria en automatización y robotica (1078)
-- =========================================================================
-- 142019 -> 1138
update planif_carreras set plan_carrera = 1138 where id = 22;

-- Hidrometría Plan II (1079)
-- =========================================================================
-- 71989 -> 1144
update planif_carreras set plan_carrera = 1144 where id = 23;


