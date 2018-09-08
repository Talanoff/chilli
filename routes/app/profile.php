<?php

Route::group([
    'as' => '.profile',
    'prefix' => 'profile',
], function () {

    Route::get('/', 'ProfileController@index')->name('.index');

});
