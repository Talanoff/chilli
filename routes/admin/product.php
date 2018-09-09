<?php

Route::group([
    'as' => '.product',
    'prefix' => 'product',
    'namespace' => 'Product',
], function () {

    Route::get('/', 'ProductController@index')->name('.index');

    Route::get('create', 'ProductController@create')->name('.create');
    Route::post('create', 'ProductController@store')->name('.store');

    Route::get('{product}/edit', 'ProductController@edit')->name('.edit');
    Route::patch('{product}/edit', 'ProductController@update')->name('.update');

    Route::delete('{product}/delete', 'ProductController@destroy')->name('.delete');

    Route::group([
        'as' => '.kit',
        'prefix' => 'kit'
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
});
