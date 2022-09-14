#!/bin/bash
#
# Arregla los permisos de los sitios/archivos/carpetas dentro de /var/www


todas_las_imgs="$DIR/*.png $WEB/*.gif $WEB/*.png"
varios_archivos="$DIR/*.json $DIR/*.lock,README.*"

# ==============================================================

# Sist. Cevarcam MPH
# Root dir:
sist="/var/www/html/wfich2.unl.edu.ar/infofich2"

chown -R www-data:develop $sist
chmod -R a-rwx $sist
chmod -R "a-s" $sist
chmod -R u+r $sist
chmod -R g+rw $sist
find $sist -type d -exec chmod u+x {} \;
find $sist -type d -exec chmod g+x {} \;

#directorio de dumps:
dumps=$sist"/vendor/fich/api-infofich/dumps/"
chmod -R u+w $dumps

#cache:
cache_prod=$sist"/app/cache/prod"
chmod -R 770 $cache_prod


# Directorio uploaads
#upload_dir=$sist"/web/uploads/imagenes/"
#chmod -R u+w $upload_dir
#chmod -R a-rwx $sist"/src/AppBundle/DataFixtures/ORM/"

#Vendors:
#$v=$sist
#HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
#HTTPDUSER='www-data'
#setfacl -dR -m u:"$HTTPDUSER":rwX -m g:develop:rwX $sist"/app/cache" $sist"/app/logs"
#setfacl -R -m u:"$HTTPDUSER":rwX -m g:develop:rwX $sist"/app/cache" $sist"/app/logs"

#setfacl -dR -m u:"$HTTPDUSER":rwX -m u:esangoi:rwX $sist"/app/cache" $sist"/app/logs"
#setfacl -dR -m u:"$HTTPDUSER":rwX -m u:bbasconcel:rwX $sist"/app/cache" $sist"/app/logs"
#setfacl -dR -m u:"$HTTPDUSER":rwX -m u:rgalarza:rwX $sist"/app/cache" $sist"/app/logs"

#setfacl -R -m u:"$HTTPDUSER":rwX -m u:esangoi:rwX $sist"/app/cache" $sist"/app/logs"
#setfacl -R -m u:"$HTTPDUSER":rwX -m u:bbasconcel:rwX $sist"/app/cache" $sist"/app/logs"
#setfacl -R -m u:"$HTTPDUSER":rwX -m u:rgalarza:rwX $sist"/app/cache" $sist"/app/logs"

chown -R www-data:develop /tmp/infofich2/cache
chmod g+w /tmp/infofich2/cache


#find $sist -type f -exec chmod u-x, {} \;
chmod -R 770 $sist"/app/logs"
#chmod -R u+rwx,g+w $sist"/app/cache/prod/" $sist"/app/cache/dev/"
#chmod -R u+rwx,g+w $sist"/app/logs/"

#chmod -R g+w $sist"/app/cache/dev/"


