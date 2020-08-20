<?php
/**
 * Created by Permaxis.
 * User: Permaxis
 * Date: 23/12/2019
 * Time: 15:35
 */

namespace Permaxis\Laravel\CrudGenerator\App\Services;

use Illuminate\Support\Facades\Route;

class CrudGenerator
{

    /**
     * Binds the Oauth2 routes into the controller.
     *
     * @param  callable|null  $callback
     * @param  array  $options
     * @return void
     */
    public static function routes($callback = null, array $options = [])
    {
        $callback = $callback ?: function ($router) {
            $router->all();
        };

        $defaultOptions = [
            'prefix' => 'logger',
            'namespace' => '\Permaxis\Laravel\CrudGenerator\App\Http\Controllers',
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }


    public static function registerPolicies($policies)
    {
    }

}