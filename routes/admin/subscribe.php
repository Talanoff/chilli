<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => '.subscribe',
    'prefix' => 'subscribe',
], function () {

    Route::get('subscribes', 'SubscribeController@index')->name('.index');

});
