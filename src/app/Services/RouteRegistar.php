<?php
namespace Permaxis\CrudGenerator\App\Services;

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
    public function bo()
    {
        //entities
        Route::name('crudgenerator.entities.')->group(function () {
            Route::get('entities', '\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@index')->name('index');
            Route::get('entities/{entityid}/show', '\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@show')->name('show');
            Route::get('entities/create', '\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@create')->name('create');
            Route::post('entities', '\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@store')->name('store');
            Route::get('entities/{entityid}/edit', '\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@edit')->name('edit');
            Route::put('entities/{entityid}', '\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@update')->name('update');
            Route::get('entities/{entityid}/delete', '\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@delete')->name('delete')->where('entityid', '[0-9]+');
            Route::delete('entities/{entityid}', '\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@destroy')->name('destroy')->where('entityid', '[0-9]+');
            Route::delete('entities', '\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@destroyEntities', ['method' => 'DELETE'])->name('destroy_entities');
        });

    }

}