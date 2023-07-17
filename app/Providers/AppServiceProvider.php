<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        //6.17 response macro
        Response::macro('caps',function(string $value){
            return Response::make(strtoupper($value));
        });
        //7.2 share view data globally
        View::share('author','Musanna Al');
    }
}
