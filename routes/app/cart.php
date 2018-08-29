<?php

Route::group([
    'as' => '.cart',
    'prefix' => 'cart'
], function () {

    Route::get('get', 'CartController@getCart')->name('.get');
    Route::post('{product}/add', 'CartController@addProductToCart')->name('.add');

});
