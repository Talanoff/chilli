<?php

namespace App\Providers;

use App\Models\Comment\Comment;
use App\Models\Order\Order;
use App\Models\Product\Brand;
use App\Models\Product\Notification;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['app.*', 'auth.*'], function () {
            $submenu = [];

            foreach (Brand::has('products')->orderBy('order')->get() as $brand) {
                $item = [
                    'name' => $brand->title,
                    'brand' => $brand->slug,
                ];

                $series = $brand->series()->has('products')->orderBy('order')->get();

                if ($series->count()) {
                    $item['models'] = [];
                    $item['models']['brand'] = $brand->getFirstMediaUrl('brand');
                    $item['models']['series'] = $series->chunk(15)->all();
                }

                array_push($submenu, $item);
            }

            View::share('nav', [
                [
                    'route' => 'app.product.index',
                    'compare' => 'app.product.*',
                    'name' => 'Каталог',
                    'submenu' => $submenu,
                ],
                [
                    'route' => 'app.promotions',
                    'compare' => 'app.promotions',
                    'name' => 'Акции',
                ],
                [
                    'route' => 'app.novelties',
                    'compare' => 'app.novelties',
                    'name' => 'Новинки',
                ],
                [
                    'route' => 'app.review.index',
                    'compare' => 'app.review.*',
                    'name' => 'Обзоры',
                ],
            ]);
        });

        View::composer('admin.*', function () {
            $nav = [
                [
                    'route' => 'admin.dashboard.index',
                    'compare' => 'admin.dashboard.*',
                    'name' => 'Панель',
                    'icon' => 'dashboard',
                ],
                [
                    'route' => 'admin.product.index',
                    'compare' => 'admin.product.*',
                    'name' => 'Товары',
                    'icon' => 'products',
                    'submenu' => [
                        [
                            'route' => 'admin.product.index',
                            'name' => 'Все товары',
                        ],
                        [
                            'route' => 'admin.product.brand.index',
                            'name' => 'Бренды',
                        ],
                        [
                            'route' => 'admin.product.series.index',
                            'name' => 'Модели',
                        ],
                        [
                            'route' => 'admin.product.category.index',
                            'name' => 'Категории',
                        ],
                        [
                            'route' => 'admin.product.characteristic.index',
                            'name' => 'Атрибуты',
                        ],
                        [
                            'route' => 'admin.product.type.index',
                            'name' => 'Типы атрибутов',
                        ],
                    ],
                ],
                [
                    'route' => 'admin.order.index',
                    'compare' => 'admin.order.*',
                    'name' => 'Заказы',
                    'icon' => 'orders',
                    'unread' => Order::whereStatus('processing')->OrWhere('status', 'no_dial')->count(),
                ],
                [
                    'route' => 'admin.comment.index',
                    'compare' => 'admin.comment.*',
                    'name' => 'Комментарии',
                    'icon' => 'comments',
                    'unread' => Comment::whereStatus('agreement')->count(),
                ],
                [
                    'route' => 'admin.review.index',
                    'compare' => 'admin.review.*',
                    'name' => 'Обзоры',
                    'icon' => 'video',
                ],
                [
                    'route' => 'admin.user.index',
                    'compare' => 'admin.user.*',
                    'name' => 'Пользователи',
                    'icon' => 'users',
                ],
                [
                    'route' => 'admin.subscribe.index',
                    'compare' => 'admin.subscribe.*',
                    'name' => 'Подписки',
                    'icon' => 'envelope',
                ],
                [
                    'route' => 'admin.notification.index',
                    'compare' => 'admin.notification.*',
                    'name' => 'Уведомления',
                    'icon' => 'bell',
                    'unread' => Notification::whereStatus('processing')->count(),
                ],
                [
                    'route' => 'admin.page.index',
                    'compare' => 'admin.page.*',
                    'name' => 'Страницы',
                    'icon' => 'pages',
                ],
                [
                    'route' => 'admin.settings.index',
                    'compare' => 'admin.settings.*',
                    'name' => 'Настройки',
                    'icon' => 'settings',
                ],
            ];

            View::share('nav', $nav);
        });

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
