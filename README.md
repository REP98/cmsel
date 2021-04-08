# Sitema CMSEL #

## Instalación ##
1. Clone los repositorios a su servidor local
2. Cree una base de datos para el sistema
3. Clone el archivo <u>.env.example</u> y renombrelo a <u>.env</u>
4. Configure su base de datos en el archivo <u>.env</u>
5. Ejecute en la consola o terminal lo siguiente
	- `composer install`
	- `php artisan migrate`
	- `php artisan db:seed`
	- `npm i`
	- `npm run dev` ó `npm run prod` dev para desarrollo o prod para producción
6. Acceda a su navegador y compruebe que no hayan problemas

## Solución de errores de Permiso ##

Ejecute lo siguiente dentro de la carpeta del proyecto

1. `sudo chmod -R 0777 .`
2. `sudo chown -R user:www-data .` reemplaze user por el su nombre de usuario

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
Sistema desarrollado en laravel 8, con Larave UI y bootstrap 5.0
