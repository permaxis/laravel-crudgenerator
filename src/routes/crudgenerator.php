<?php
/*Route::group(['middleware' =>[ 'web']], function () {
    Route::get('entities', '\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntitiesController@index');
   // Route::get('entities/search','\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntitiesController@processSearch')->name('entities.search');
    Route::resource('entities','\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntitiesController');
    Route::get('entities/{id}/delete','\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntitiesController@delete')->name('entities.delete')->where('entityid', '[0-9]+');
    Route::delete('entities','\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntitiesController@destroyEntities',['method' => 'DELETE'])->name('entities.destroy_entities');
});*/


    /*Route::name('entities.')->middleware('web')->group(function () {
        Route::get('entities', '\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntityModelsController@index')->name('index');
        Route::get('entities/{id}/show','\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntityModelsController@show')->name('show');
        Route::get('entities/create','\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntityModelsController@create')->name('create');
        Route::post('entities','\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntityModelsController@store')->name('store');
        Route::get('entities/{id}/edit','\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntityModelsController@edit')->name('edit');
        Route::put('entities/{id}','\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntityModelsController@update')->name('update');
        Route::get('entities/{id}/delete','\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntityModelsController@delete')->name('delete')->where('entityid', '[0-9]+');
        Route::delete('entities/{id}','\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntityModelsController@destroy')->name('destroy')->where('entityid', '[0-9]+');
        Route::delete('entities','\Permaxis\LaravelCrudGenerator\app\Http\Controllers\EntityModelsController@destroyEntities',['method' => 'DELETE'])->name('destroy_entities');
    });*/
