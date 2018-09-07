<?php

Route::group([
    'as' => '.cart',
    'prefix' => 'cart'
], function () {

    Route::get('/', 'CartController@index')->name('.index');

    Route::post('quantity/{checkout}/{action}', 'CartController@quantity')->name('.quantity');
    Route::delete('delete/{checkout}', 'CartController@delete')->name('.delete');

    Route::get('get', 'CartController@getCart')->name('.get');
    Route::post('{product}/add', 'CartController@addProductToCart')->name('.add');

});
