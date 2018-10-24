<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => '.page',
    'prefix' => 'page'
], function () {

    Route::get('/', 'PageController@index')->name('.index');
    Route::get('{page}/edit', 'PageController@edit')->name('.edit');
    Route::patch('{page}/update', 'PageController@update')->name('.update');

});
