<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => '.favourites',
    'prefix' => 'favourites',
], function () {

    Route::get('/', 'FavouritesController@index')->name('.index');
    Route::get('list', 'FavouritesController@list')->name('.list');

    Route::post('{product}/add', 'FavouritesController@add')->name('.add');
    Route::post('{favourite}/remove', 'FavouritesController@remove')->name('.remove');

});
