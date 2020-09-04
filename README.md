# laravel-crudgenerator

## About Laravel CrudGenerator
Laravel CrudGenerator is a package that install in your laravel project a simple crud (Create Read Update Delete) interface to manage your model.
The interface is based on Bootstrap 4 Theme

## Versions
| Laravel | laravel-crud-generator |
| --- | --- |
| 6.0 | ^1.0 |

## 1. Install package

> composer require permaxis/laravel-crudgenerator

This package will also install a package dependency named "permaxis/laravel-core", a toolbox libraries for laravel

- Register your package in your config/app.php file, add the package to your service provider

> \Permaxis\Laravel\CrudGenerator\CrudGeneratorServiceProvider::class,


## 2. Generates crud based on Model

For example, you have a model named Article located in app\Models folder. it full namespace is App\Models\Article

Execute thecommand below:

> php artisan permaxis:make:crudgenerator --m="\App\Models\Article" --c=ArticleController --ov --oc --rn=bo

It generates a controller named "ArticleController" in your app/Http/Controllers folder

It generates a folder named "articles" in your resource views folder that contains these views:

index, create, edit, delete, form, search

Here are the listed options for the package:
```
Description:
  Crud generator

Usage:
  permaxis:make:crudgenerator [options]

Options:
      --m[=M]           The name of the model
      --vd[=VD]         The sub directory of views to be created
      --rn[=RN]         The route name prefix
      --c[=C]           The name of the controller
      --cd[=CD]         The path of controller to be created
      --oc              Override creation of controller
      --bc              Bypass creation of controller
      --ov              Override creation of views
      --bv              Bypass creation of views
      --sn[=SN]         Singular name of the entity (lower)
      --pn[=PN]         Plural name of the entity (lower)
      --pk[=PK]         Package name
      --api[=API]       Api enabled
      --cmt[=CMT]       Enable comment [default: "1"]
````

## 3. Create Routes for crud interface

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

## 4. Publish assets

> php artisan vendor:publish --tag=permaxis_crudgenerator_assets

It publishes assets folder in your Resources folder : resources/vendor/permaxis/laravel-crugenerator/assets

The script "crudgenerator.js" asset is used by the crud interface.

## 5. Publish layouts

Publish include folder in Resources views folder : resources/views/vendor/permaxis/laravel-crugenerator.
It is used for common files
> php artisan vendor:publish --tag=permaxis_crudgenerator_include

Publish layouts folder in Resources views folder : resources/views/vendor/permaxis/laravel-crugenerator.
The views for articles folder  extend the  layout "admin.blade.php"
> php artisan vendor:publish --tag=permaxis_crudgenerator_layouts

``` html
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script src="{{ asset('js/all.js') }}"></script>

    @yield('javascripts')
    @yield('stylesheets')
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
           @include('vendor/permaxis/laravel-crudgenerator/layouts._menu')
        </div>
        <div class="col-sm-10">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
```

You can override this layout or use your own layout, but the assets below are required
- Jquery :
https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js
https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js
- Bootstrap 4:
https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css
https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js
- fontawesome:
https://use.fontawesome.com/releases/v5.14.0/css/all.css
- Package assets
resources/vendor/permaxis/laravel-crugenerator/assets/crudgenerator.js that you can publish to your public directory or use laravel mix and include it in your js/all.js







