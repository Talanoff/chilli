<?php

Route::get('/', 'CommonController@home')->name('.home');

Route::get('warranty', 'CommonController@warranty')->name('.warranty');
Route::get('delivery', 'CommonController@delivery')->name('.delivery');
Route::get('contacts', 'CommonController@contacts')->name('.contacts');

Route::post('search', 'CommonController@search')->name('.search');
Route::post('subscribe', 'CommonController@subscribe')->name('.subscribe');
