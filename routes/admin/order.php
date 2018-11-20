<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => '.order',
    'prefix' => 'order',
], function () {

    Route::get('/', 'OrderController@index')->name('.index');
    Route::post('search', 'OrderController@search')->name('.search');
    Route::post('{order}/update', 'OrderController@update')->name('.update');
    Route::get('{order}', 'OrderController@show')->name('.show');

});
