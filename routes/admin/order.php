<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => '.order',
    'prefix' => 'order',
], function () {

    Route::get('/', 'OrderController@index')->name('.index');
    Route::get('{order}', 'OrderController@show')->name('.show');

    Route::post('{order}/update', 'OrderController@update')->name('.update');

});
