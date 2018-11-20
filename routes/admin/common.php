<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', 'DashboardController@index')->name('.dashboard.index');
Route::get('/', function() {
    return \redirect()->route('admin.order.index');
})->name('.dashboard.index');

Route::delete('/media/{media}/delete', 'MediaController@delete')->name('.media.delete');
