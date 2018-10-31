<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => '.notification',
    'prefix' => 'notification',
], function () {

    Route::get('/', 'NotificationController@index')->name('.index');
    Route::patch('{notification}/status', 'NotificationController@changeStatus')->name('.status');

});
