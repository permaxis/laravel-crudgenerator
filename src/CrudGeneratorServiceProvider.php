<?php

namespace Permaxis\CrudGenerator;

use Illuminate\Support\ServiceProvider;
use Permaxis\CrudGenerator\App\Console\CrudGeneratorCommand;

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
            __DIR__.'/public/assets' => public_path('vendor/permaxis/crudgenerator/assets'),
        ], 'permaxis_crudgenerator_assets');

        //publish layouts
        $this->publishes([
            __DIR__.'/public/resources/views/layouts' =>  base_path('resources/views/vendor/permaxis/crudgenerator'),
        ], 'permaxis_crudgenerator_layouts');


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
