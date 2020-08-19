<?php
/*Route::group(['middleware' =>[ 'web']], function () {
    Route::get('entities', '\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@index');
   // Route::get('entities/search','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@processSearch')->name('entities.search');
    Route::resource('entities','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController');
    Route::get('entities/{id}/delete','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@delete')->name('entities.delete')->where('entityid', '[0-9]+');
    Route::delete('entities','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@destroyEntities',['method' => 'DELETE'])->name('entities.destroy_entities');
});*/

/*Route::name('entities.')->middleware('web')->group(function () {
    Route::get('entities', '\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@index')->name('index');
    Route::get('entities/{id}/show','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@show')->name('show');
    Route::get('entities/create','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@create')->name('create');
    Route::post('entities','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@store')->name('store');
    Route::get('entities/{id}/edit','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@edit')->name('edit');
    Route::put('entities/{id}','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@update')->name('update');
    Route::get('entities/{id}/delete','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@delete')->name('delete')->where('entityid', '[0-9]+');
    Route::delete('entities/{id}','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@destroy')->name('destroy')->where('entityid', '[0-9]+');
    Route::delete('entities','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@destroyEntities',['method' => 'DELETE'])->name('destroy_entities');
});*/

Route::name('entities.')->prefix('bs4')->middleware('web')->group(function () {
    Route::get('entities', '\Permaxis\CrudGenerator\App\Http\Controllers\EntityModelsController@index')->name('index');
    Route::get('entities/{id}/show','\Permaxis\CrudGenerator\App\Http\Controllers\EntityModelsController@show')->name('show');
    Route::get('entities/create','\Permaxis\CrudGenerator\App\Http\Controllers\EntityModelsController@create')->name('create');
    Route::post('entities','\Permaxis\CrudGenerator\App\Http\Controllers\EntityModelsController@store')->name('store');
    Route::get('entities/{id}/edit','\Permaxis\CrudGenerator\App\Http\Controllers\EntityModelsController@edit')->name('edit');
    Route::put('entities/{id}','\Permaxis\CrudGenerator\App\Http\Controllers\EntityModelsController@update')->name('update');
    Route::get('entities/{id}/delete','\Permaxis\CrudGenerator\App\Http\Controllers\EntityModelsController@delete')->name('delete')->where('entityid', '[0-9]+');
    Route::delete('entities/{id}','\Permaxis\CrudGenerator\App\Http\Controllers\EntityModelsController@destroy')->name('destroy')->where('entityid', '[0-9]+');
    Route::delete('entities','\Permaxis\CrudGenerator\App\Http\Controllers\EntityModelsController@destroyEntities',['method' => 'DELETE'])->name('destroy_entities');
});