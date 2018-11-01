<?php

namespace App\Providers;

use App\Models\Setting\Setting;
use App\Services\Navigation;
use Carbon\Carbon;
use DOMDocument;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        setlocale(LC_TIME, 'ru_RU.utf-8');

        Carbon::setLocale(app()->getLocale());

        Blade::component('components.item', 'item');

        View::composer(['app.*', 'auth.*'], function () {
            View::share('settings', Setting::query()->get()->groupBy('type'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
