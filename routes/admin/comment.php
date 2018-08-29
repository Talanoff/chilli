<?php

Route::group([
    'as' => '.comment',
    'prefix' => 'comment',
], function () {

    Route::get('/', 'CommentController@index')->name('.index');

    Route::get('{comment}/edit', 'CommentController@edit')->name('.edit');

});
