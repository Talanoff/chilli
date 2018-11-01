<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'CommonController@home')->name('.home');

Route::post('search', 'CommonController@search')->name('.search');
Route::post('subscribe', 'CommonController@subscribe')->name('.subscribe');

Route::get('{page}', 'CommonController@page')->name('.page');
