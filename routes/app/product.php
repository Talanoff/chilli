<?php

Route::group([
    'as' => '.product',
    'prefix' => 'product'
], function () {

    Route::get('{product}', 'ProductController@show')->name('.show');

});
