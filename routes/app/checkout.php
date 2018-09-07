<?php

Route::group([
    'as' => '.checkout',
    'prefix' => 'checkout',
], function () {

    Route::get('/', 'CheckoutController@index')->name('.index');
    Route::post('/', 'CheckoutController@store')->name('.store');

    Route::get('cities', 'CheckoutController@getCities')->name('.cities');
    Route::get('warehouses/{city}/{state}', 'CheckoutController@getWarehoueses')->name('.warehouses');

});
