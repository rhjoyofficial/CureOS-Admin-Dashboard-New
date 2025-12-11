<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share user role with all views
        View::composer('*', function ($view) {
            $view->with('userRole', auth()->check() ? auth()->user()->getRoleNames()->first() : null);
        });
    }
}
