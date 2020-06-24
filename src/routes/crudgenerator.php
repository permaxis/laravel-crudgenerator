<?php
/*Route::group(['middleware' =>[ 'web']], function () {
    Route::get('entities', '\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@index');
   // Route::get('entities/search','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@processSearch')->name('entities.search');
    Route::resource('entities','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController');
    Route::get('entities/{entityid}/delete','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@delete')->name('entities.delete')->where('entityid', '[0-9]+');
    Route::delete('entities','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@destroyEntities',['method' => 'DELETE'])->name('entities.destroy_entities');
});*/

Route::name('entities.')->middleware('web')->group(function () {
    Route::get('entities', '\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@index')->name('index');
    Route::get('entities/{entityid}/show','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@show')->name('show');
    Route::get('entities/create','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@create')->name('create');
    Route::post('entities','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@store')->name('store');
    Route::get('entities/{entityid}/edit','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@edit')->name('edit');
    Route::put('entities/{entityid}','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@update')->name('update');
    Route::get('entities/{entityid}/delete','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@delete')->name('delete')->where('entityid', '[0-9]+');
    Route::delete('entities/{entityid}','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@destroy')->name('destroy')->where('entityid', '[0-9]+');
    Route::delete('entities','\Permaxis\CrudGenerator\App\Http\Controllers\EntitiesController@destroyEntities',['method' => 'DELETE'])->name('destroy_entities');
});