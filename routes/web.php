<?php

Auth::routes();

Route::get('dd', function() {
	$imports = simplexml_load_file('/Users/olegtalanov/Code/chilli/storage/1cExchange/2019-04-25_09:48_1556185697/import.xml');

dd($imports->Каталог->Товары->Товар);
});

Route::group([
    'as' => 'admin',
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['auth', 'admin'],
], function () {

    require_once(__DIR__ . '/admin/product.php');
    require_once(__DIR__ . '/admin/order.php');
    require_once(__DIR__ . '/admin/comment.php');
    require_once(__DIR__ . '/admin/user.php');
    require_once(__DIR__ . '/admin/review.php');
    require_once(__DIR__ . '/admin/settings.php');
    require_once(__DIR__ . '/admin/page.php');
    require_once(__DIR__ . '/admin/subscribe.php');
    require_once(__DIR__ . '/admin/notification.php');
    require_once(__DIR__ . '/admin/common.php');

});

Route::group([
    'as' => 'app',
    'namespace' => 'Front',
], function () {

    require_once(__DIR__ . '/app/product.php');
    require_once(__DIR__ . '/app/review.php');
    require_once(__DIR__ . '/app/cart.php');
    require_once(__DIR__ . '/app/checkout.php');
    require_once(__DIR__ . '/app/profile.php');
    require_once(__DIR__ . '/app/favourites.php');
    require_once(__DIR__ . '/app/notification.php');
    require_once(__DIR__ . '/app/common.php');

});
