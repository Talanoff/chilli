<?php

Route::group([
    'as' => '.profile',
    'prefix' => 'profile',
], function () {

    Route::get('/', 'ProfileController@index')->name('.index');

    Route::get('edit', 'ProfileController@edit')->name('.edit');
    Route::patch('update', 'ProfileController@update')->name('.update');

});
