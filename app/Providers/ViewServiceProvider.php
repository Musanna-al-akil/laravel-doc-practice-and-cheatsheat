<?php

namespace App\Providers;

use App\View\Composers\MsgComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //7.3
        View::composer('viewAndBlade', MsgComposer::class);
    }
}
