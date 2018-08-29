<?php

Route::get('/', 'DashboardController@index')->name('.dashboard.index');

Route::delete('/media/{media}/delete', 'MediaController@delete')->name('.media.delete');
