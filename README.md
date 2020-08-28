# laravel-crudgenerator

## About Laravel CrudGenerator
Laravel CrudGenerator is a package that install in your laravel project a simple crud (Create Read Update Delete) interface to manage your model.
The interface is based on Bootstrap 4 Theme

## Installation
1. Install package

> composer require permaxis/laravel-crudgenerator

This package will also install a package dependencie named "permaxis/laravel-core", a toolbox libraries for laravel

- Register your package in your config/app.php file, add the package service provider

> \Permaxis\Laravel\CrudGenerator\CrudGeneratorServiceProvider::class,


2. Generates crud based on Model

For example, you have a model named Article located in app\Models folder. it full namespace is App\Models\Article

Execute thecommand below:

> php artisan permaxis:make:crudgenerator --m=\\App\\Models\\Article --c=ArticleController --ov --oc --rn=bo

It generates a controller named "ArtcileController" in your app/Http/Controllers folder

It generates a folder named "articles" in your resource views folder that contains theses views:

index, create, edit, delete, form, search

3. Create Routes for crud interface

For accessing to the crud interface via browser, you have to create routes:

Add this function to your app/Providers/AppServiceProvider.php file

``` php
public function registerRoutes()
    {
        \Permaxis\Laravel\CrudGenerator\App\Services\CrudGenerator::routes(function($router) {
            $router->routes([
                [
                    'resource' => 'articles',
                    'controller' => '\App\Http\Controllers\ArticlesController',
                    'route_name_prefix' => 'bo.articles'
                ]
            ]);
        }, array('middleware' => ['web']));
    }
```
Call this method in your register method of your AppServiceProvider class

``` php
...
public function register()
    {
        $this->registerRoutes();
    }
...
```
It creates routes for resource articles. The crud interface is accessing at the url /articles

4. Publish assets, layouts

Publish assets
> php artisan vendor:publish --tag=permaxis_crudgenerator_assets

It publishes assets folder in your Resources folder : resources/vendor/permaxis/laravel-crugenerator/assets

The script "crudgenerator.js" asset is used by the crud interface.

Publish layout

> php artisan vendor:publish --tag=permaxis_crudgenerator_layouts
> php artisan vendor:publish --tag=permaxis_crudgenerator_include

It publishes layouts folder in your Resources views folder : resources/views/vendor/permaxis/laravel-crugenerator.
The views for articles folder  extend the  layout "admin.blade.php

It publishes include folder in your Resources views folder : resources/views/vendor/permaxis/laravel-crugenerator.
It is used for common files





