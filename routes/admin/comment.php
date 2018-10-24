<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => '.comment',
    'prefix' => 'comment',
], function () {

    Route::get('/', 'CommentController@index')->name('.index');

    Route::get('{comment}/edit', 'CommentController@edit')->name('.edit');
    Route::patch('{comment}/update', 'CommentController@update')->name('.update');
    Route::delete('{comment}/delete', 'CommentController@destroy')->name('.delete');

});
