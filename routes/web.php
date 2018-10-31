<?php

Auth::routes();

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
    require_once(__DIR__ . '/admin/common.php');
    require_once(__DIR__ . '/admin/subscribe.php');
    require_once(__DIR__ . '/admin/notification.php');

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
