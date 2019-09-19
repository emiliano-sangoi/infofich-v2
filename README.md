InfoFICH en Symfony 
========================
Sistema web desarrollado en Symfony 2.8 para gestión de información institucional de la FICH.

## Pasos para la Instalación
--------------

Instalación
--------------

1. Clonar repositorio
```sh
$ git clone ssh://extyvt@fich.unl.edu.ar///var/repos-git/symfony-infofich infofich2
```
2. Corregir permisos:
Como se especifíca en la [documentación de Symfony](https://symfony.com/doc/2.8/setup/file_permissions.html), se deben corregir los permisos en el directorio root del proyecto:
```sh
$ cd infofich2
```
```sh
$ HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
```
```sh
$ sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX app/cache app/logs
```
```sh
$ sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX app/cache app/logs
```
3. Instalar dependencias del proyecto:
```sh
$ composer install
```
```sh
$ php app/console assets:install
```
```sh
$ php app/console assets:install --symlink
```
```sh
$ cd web/
```
```sh
$ npm install
```
4.  Configuración de la base de datos:
```sh
$ php app/console doctrine:database:create
```
```sh
$ php app/console doctrine:schema:update --force
```
```sh
$ php app/console doctrine:fixtures:load
```
