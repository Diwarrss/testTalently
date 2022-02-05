# TestTalently - Laravel - Vuejs - Sanctum 

## Tecnologías implementadas

* **[Laravel 8x]** - Framework basado en PHP para aplicaciones web con una sintaxis elegante y expresiva. [Leer más](https://laravel.com/docs/8.x).
* **[Laravel Sanctum]** - Las API suelen utilizar tokens para autenticar a los usuarios. [Leer más](https://laravel.com/docs/8.x/sanctum).
* **[PHP >= 8.0.10]** => Hypertext Preprocessor
* **[Nodejs >= 16.13.2]** => Version of nodejs
* **[MySQL]** => Sistema de gestión de bases de datos relacional.
* **[Composer]** => Herramienta para la gestión de dependencias en PHP. [Leer más](https://getcomposer.org/).

## Configuración de instalación

```bash
# clone repository
$ git clone https://github.com/Diwarrss/testTalently.git
# install dependencies
$ composer install
# config .env
$ cp .env.example .env
# generate key app laravel
$ php artisan key:generate
# config files storage
$ php artisan storage:link
# load data in BD
$ php artisan migrate --seed

# install dependencies of npm
$ npm install
# compile files webpack dev
$ npm run dev

# launch server in local
$ php artisan serve
```

# License

The Laravel framework is open-sourced software licensed under the MIT license.
