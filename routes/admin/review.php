<?php

Route::group([
    'as' => '.review',
    'prefix' => 'review',
], function () {

    Route::get('/', 'ReviewController@index')->name('.index');

    Route::get('create', 'ReviewController@create')->name('.create');
    Route::post('create', 'ReviewController@store')->name('.store');

    Route::get('meta', 'ReviewController@meta')->name('.meta');
    Route::post('meta', 'ReviewController@metaStore')->name('.meta.store');

    Route::get('{review}/edit', 'ReviewController@edit')->name('.edit');
    Route::patch('{review}/update', 'ReviewController@update')->name('.update');

    Route::delete('{review}/delete', 'ReviewController@destroy')->name('.delete');

});
