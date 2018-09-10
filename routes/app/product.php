<?php

Route::get('products', 'ProductController@index')->name('.product.index');

Route::get('promotions', 'ProductController@index')->name('.promotions');
Route::get('novelties', 'ProductController@index')->name('.novelties');

Route::group([
    'as' => '.product',
    'prefix' => 'product',
], function () {

    Route::get('{product}', 'ProductController@show')->name('.show');

    Route::post('{product}/fast-buy', 'ProductController@fastBuy')->name('.fast-buy');

    Route::post('{product}/comment', 'ProductController@comment')->name('.comment');
    Route::post('{product}/rate', 'ProductController@rate')->name('.rate');

});
