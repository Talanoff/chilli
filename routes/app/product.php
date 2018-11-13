<?php

use Illuminate\Support\Facades\Route;

Route::get('products', 'ProductController@index')->name('.product.index');
Route::get('promotions', 'ProductController@promotions')->name('.promotions');
Route::get('novelties', 'ProductController@novelties')->name('.novelties');

Route::get('{product}/fast-buy', 'FastBuyController@fastBuyDetails')->name('.fast-buy.details');
Route::post('{product}/fast-buy', 'FastBuyController@fastBuy')->name('.fast-buy.send');

Route::group([
    'as' => '.product',
    'prefix' => 'product',
], function () {

    Route::post('search', 'ProductController@search')->name('.search');
    Route::post('{product}/comment', 'ProductController@comment')->name('.comment');
    Route::post('{product}/rate', 'ProductController@rate')->name('.rate');
    Route::get('{product}', 'ProductController@show')->name('.show');

});
