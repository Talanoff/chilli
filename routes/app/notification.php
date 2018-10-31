<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => '.notification',
    'prefix' => 'notification',
], function () {

    Route::post('{product}/add', 'NotificationController@add')->name('.add');

});
