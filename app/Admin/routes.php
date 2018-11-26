<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('auth/login', 'AuthController@getLogin');
    $router->post('auth/login', 'AuthController@postLogin');

    $router->get('/', 'HomeController@index');

    $router->resources([
        'shops'         => ShopController::class,
        'shopDetails'   => ShopDetailController::class,
        'deopts'        => DeoptController::class,
        'goods'        => GoodsController::class,
    ]);

    $router->post('/shops/status', 'ShopController@status');

    $router->get('/goods/upGoods/{deopt_id}', 'GoodsController@upGoods')->name('goods.upGoods');

//    $router->get('/shopDetail/{shop_id}', 'ShopDetailController@index')->name('shop.detail');
});
