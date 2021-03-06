<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => '.product',
    'prefix' => 'product',
    'namespace' => 'Product',
], function () {

    Route::get('/', 'ProductController@index')->name('.index');
    Route::get('list', 'ProductController@list')->name('.list');
    Route::post('search', 'ProductController@index')->name('.search');

    Route::get('create', 'ProductController@create')->name('.create');
    Route::post('create', 'ProductController@store')->name('.store');

    Route::get('meta', 'ProductController@meta')->name('.meta');
    Route::post('meta', 'ProductController@metaStore')->name('.meta.store');

    Route::get('{product}/edit', 'ProductController@edit')->name('.edit');
    Route::patch('{product}/edit', 'ProductController@update')->name('.update');

    Route::delete('{product}/delete', 'ProductController@destroy')->name('.delete');

    Route::group([
        'as' => '.kit',
        'prefix' => 'kit',
    ], function () {

        Route::get('{product}', 'KitController@list')->name('.list');
        Route::post('{product}/add', 'KitController@add')->name('.add');
        Route::delete('{product}/{kit}/delete', 'KitController@remove')->name('.delete');

    });

    $routes = [
        'characteristic' => 'Characteristic',
        'category' => 'Category',
        'type' => 'CharacteristicType',
        'brand' => 'Brand',
        'series' => 'Series',
    ];

    foreach ($routes as $key => $value) {
        Route::group([
            'as' => '.' . $key,
            'prefix' => $key,
        ], function () use ($key, $value) {

            Route::get('/', $value . 'Controller@index')->name('.index');

            Route::get('create', $value . 'Controller@create')->name('.create');
            Route::post('create', $value . 'Controller@store')->name('.store');

            Route::get('{' . $key . '}/edit', $value . 'Controller@edit')->name('.edit');
            Route::patch('{' . $key . '}/update', $value . 'Controller@update')->name('.update');

            Route::delete('{' . $key . '}/delete', $value . 'Controller@destroy')->name('.delete');

        });
    }

    Route::get('series/{id}/list', 'SeriesController@list')->name('.series.list');
});
