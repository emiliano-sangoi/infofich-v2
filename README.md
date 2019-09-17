InfoFICH en Symfony 
========================


## Pasos para la Instalación
--------------

Instalación
--------------

1. Clonar repositorio
```sh
$ git clone ssh://extyvt@fich.unl.edu.ar///var/repos-git/symfony-argcapnet
```
2. Corregir permisos:
Como se especifíca en la [documentación de Symfony](https://symfony.com/doc/2.8/setup/file_permissions.html), se deben corregir los permisos en el directorio root del proyecto:
```sh
$ cd symfony-argcapnet
$ HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
$ sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX app/cache app/logs
$ sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX app/cache app/logs
```
3. Instalar dependencias del proyecto:
```sh
$ cd symfony-argcapnet
$ composer install
```
En el proceso generalmente se pide los datos de conexión a la base de datos.
