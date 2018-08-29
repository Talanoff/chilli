<?php

Route::get('products', 'ProductController@index')->name('.product.index');

Route::get('promotions', 'ProductsController@index')->name('.product.promotion');

Route::group([
    'as' => '.product',
    'prefix' => 'product'
], function () {

    Route::get('{product}', 'ProductController@show')->name('.show');

});
