<?php

Route::get('reviews', 'ReviewController@index')->name('.review.index');

Route::group([
    'as' => '.review',
    'prefix' => 'review',
], function () {

    Route::get('{review}', 'ReviewController@show')->name('.show');
    Route::post('{review}/comment', 'ReviewController@comment')->name('.comment');

});
