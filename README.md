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

