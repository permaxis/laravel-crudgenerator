<?php

namespace Permaxis\LaravelCrudGenerator;

use Illuminate\Support\ServiceProvider;
use Permaxis\LaravelCrudGenerator\app\Console\CrudGeneratorCommand;

class CrudGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelpers();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //publish views
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'crudgenerator');

        //publish assets
        $this->publishes([
            __DIR__.'/resources/assets' => resource_path('vendor/permaxis/laravel-crudgenerator/assets'),
        ], 'permaxis_crudgenerator_assets');

        //publish layouts
        $this->publishes([
            __DIR__.'/resources/views/layouts' =>  base_path('resources/views/vendor/permaxis/laravel-crudgenerator/layouts'),
        ], 'permaxis_crudgenerator_layouts');

        //publish include
        $this->publishes([
            __DIR__.'/resources/views/include' =>  base_path('resources/views/vendor/permaxis/laravel-crudgenerator/include'),
        ], 'permaxis_crudgenerator_include');

        //publish translations
        $this->publishes([
            __DIR__.'/resources/lang/en' =>  base_path('resources/lang/vendor/permaxis_crudgenerator/en'),
        ], 'permaxis_crudgenerator_translations');



        if ($this->app->runningInConsole()) {
            $this->commands([
                CrudGeneratorCommand::class,
            ]);
        }

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'permaxis_crudgenerator');
    }

    public function registerHelpers()
    {
        foreach (glob(__DIR__ . '/app/Helpers/*.php') as $file) {
            require_once($file);
        }
    }
}
