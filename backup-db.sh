#!/bin/bash
#
# Script de backup para la base de datos
#
fecha_hora=$(date "+%Y%m%d_%H%M");
target_path="/home/esangoi/backup-dbs/infofich2/$fecha_hora.sql.gz";
db_user=uif2
db_name=db_infofich2
/usr/bin/mysqldump -u $db_user $db_name | gzip > $target_path
