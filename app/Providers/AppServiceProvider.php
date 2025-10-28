<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Repositories\Cart\CartRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('filter', function ($attribute, $value, $params) {
            return ! in_array(strtolower($value), $params);
        }, 'This name is prohibited!');

        Paginator::useBootstrapFour();

        // مشاركة بيانات الكارت مع جميع الـ views (بما فيها المكونات)
        View::composer('*', function ($view) {
            // نستدعي الريبو الخاص بالكارت
            $cartRepo = app(CartRepository::class);

            // نجلب العناصر والمجموع الكلي
            $items = $cartRepo->get();
            $total = $cartRepo->total();

            // نشاركهم مع كل الـ views
            $view->with([
                'items' => $items,
                'total' => $total,
            ]);
        });
    }
}
