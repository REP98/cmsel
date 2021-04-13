# Sitema CMSEL #

## Instalación ##
1. Clone los repositorios a su servidor local
2. Cree una base de datos para el sistema
3. Clone el archivo <u>.env.example</u> y renombrelo a <u>.env</u>
4. Configure su base de datos en el archivo <u>.env</u>
5. Ejecute en la consola o terminal lo siguiente
	- `composer install` Instalamos las Dependencias
	- `php artisan migrate` Migramos la Base de Datos
	- `php artisan db:seed` Migramos los datos por defecto del sistema
	- `php artisan storage:link` Publicamos a Storage para tener acceso desde public
	- `php artisan route:tojs` Pasamos las rutas de web.php a routes.js
	- `npm i` Instalamos las dependencias del Front-END
	- `npm update` solo si ya tenemos un repositorio anterior luego de instalar las dependecias es recomendable actualizar las pre-existentes
	- `npm run dev` ó `npm run prod` dev para desarrollo o prod para producción
6. Acceda a su navegador y compruebe que no hayan problemas

## Solución de errores de Permiso ##

Ejecute lo siguiente dentro de la carpeta del proyecto

1. `sudo chmod -R 0777 .`
2. `sudo chown -R user:www-data .` reemplaze user por el su nombre de usuario

## NOTAS ##

Por poblemas de incompativilidades con laravel se removio el paquete <u>cviebrock/eloquent-sluggable</u> Ejecute
el siguinete comando para removerlo si lo tiene instalado dentro de su carpeta vendor.
- `composer remove cviebrock/eloquent-sluggable`

## Entorno ##

- Apache/2.4.29 (Ubuntu)
- MySql v5.7.33
- PHP 8.0.3 (cli) (built: Mar  5 2021 07:53:56) ( NTS )
- Composer version 2.0.8 2020-12-03 17:20:38
- NPM 7.8.0
- NODEJS v14.15.4
- Laravel Installer 4.2.4
- Laravel V8.12
-
### Editores y SO ###

* [Sublime Text V3.2.2](https://www.sublimetext.com/3)
* [Sublime Merge Stable Build 2050](https://sublimemerge.com)
* Xubunu 20.04

### Especificaciones de Desarrollo ###
Sistema desarrollado en laravel 8, con Larave UI y Bootstrap 5.0




