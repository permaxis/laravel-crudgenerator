<?php
namespace Permaxis\LaravelCrudGenerator\App\Services;

use Illuminate\Contracts\Routing\Registrar as Router;
use Illuminate\Support\Facades\Route;

/**
 * Created by Permaxis.
 * User: Permaxis
 * Date: 23/12/2019
 * Time: 15:24
 */
class RouteRegistrar
{
    /**
     * The router implementation.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for backend api logger.
     *
     * @return void
     */
    public function routes($options = array())
    {
        foreach ($options as $option)
        {
            $resource = $option['resource'];
            $controller = $option['controller'];
            $route_name_prefix = (isset($option['route_name_prefix']))? $option['route_name_prefix'].'.' : '';
            Route::get($resource, $controller.'@index')->name($route_name_prefix.'index');
            Route::get($resource.'/{id}/show',$controller.'@show')->name($route_name_prefix.'show');
            Route::get($resource.'/create',$controller.'@create')->name($route_name_prefix.'create');
            Route::post($resource,$controller.'@store')->name($route_name_prefix.'store');
            Route::get($resource.'/{id}/edit',$controller.'@edit')->name($route_name_prefix.'edit');
            Route::put($resource.'/{id}',$controller.'@update')->name($route_name_prefix.'update');
            Route::get($resource.'/{id}/delete',$controller.'@delete')->name($route_name_prefix.'delete')->where('entityid', '[0-9]+');
            Route::delete($resource.'/{id}',$controller.'@destroy')->name($route_name_prefix.'destroy')->where('entityid', '[0-9]+');
            Route::delete($resource,$controller.'@destroyEntities',['method' => 'DELETE'])->name($route_name_prefix.'destroy_entities');
        }
    }

}