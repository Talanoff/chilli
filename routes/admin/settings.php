<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => '.settings',
    'prefix' => 'settings',
], function () {

    Route::get('/', 'SettingsController@index')->name('.index');

    Route::patch('{setting}/update', 'SettingsController@update')->name('.update');

});
