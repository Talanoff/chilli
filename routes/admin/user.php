<?php

Route::group([
    'as' => '.user',
    'prefix' => 'user',
], function () {

    Route::get('/', 'UserController@index')->name('.index');

    Route::get('{user}', 'UserController@show')->name('.show');
    Route::get('{user}/edit', 'UserController@edit')->name('.edit');
    Route::patch('{user}/update', 'UserController@update')->name('.update');

    Route::delete('{user}/delete', 'UserController@destroy')->name('.delete');

});
