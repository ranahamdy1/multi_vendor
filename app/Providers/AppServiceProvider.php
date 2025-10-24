<?php

namespace App\Providers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Validator::extend('filter',function($attribute, $value,$params){
            return ! in_array(strtolower($value), $params);
        },'This name is prohibited!');

        Paginator::useBootstrapFour();
        //Paginator::defaultView('pagination.custom');
    }
}
