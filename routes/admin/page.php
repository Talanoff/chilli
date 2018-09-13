<?php

Route::group([
    'as' => '.page',
    'prefix' => 'page'
], function () {

    Route::get('/', 'PageController@index')->name('.index');


});
