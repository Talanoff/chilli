<?php

Route::group([
    'as' => '.order',
    'prefix' => 'order'
], function() {

    Route::get('/', 'OrderController@index')->name('.index');
    Route::get('{order}', 'OrderController@show')->name('.show');

});
