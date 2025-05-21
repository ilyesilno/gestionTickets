<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\WebsiteSetting;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Injecter le logo dans la vue de login
        View::composer('auth.login', function ($view) {
            $logoPath = WebsiteSetting::getValue('login_logo') ?? 'default-logo.png';
            $view->with('logoPath', $logoPath);
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
}
