<?php

namespace App\Providers;

use App\Models\Comment\Comment;
use App\Models\Order\Checkout;
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
        View::composer('app.*', function () {
            View::share('nav', [
                [
                    'route' => 'app.product.index',
                    'compare' => 'app.product.*',
                    'name' => 'Каталог',
                ],
                [
                    'route' => 'app.promotions.index',
                    'compare' => 'app.promotions.*',
                    'name' => 'Акции',
                ],
                [
                    'route' => 'app.novelties.index',
                    'compare' => 'app.novelties.*',
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
                            'route' => 'admin.product.category.index',
                            'name' => 'Категории',
                        ],
                        [
                            'route' => 'admin.product.attribute.index',
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
                    'unread' => Checkout::query()
                                        ->whereStatus('in_processing')
                                        ->count(),
                ],
                [
                    'route' => 'admin.comment.index',
                    'compare' => 'admin.comment.*',
                    'name' => 'Комментарии',
                    'icon' => 'comments',
                    'unread' => Comment::query()
                                       ->whereStatus('agreement')
                                       ->count(),
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
