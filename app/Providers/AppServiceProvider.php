<?php

namespace App\Providers;

use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema as DbSchema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (! DbSchema::hasTable('settings')) {
                return;
            }

            $view->with('siteSettings', Setting::current());
            $view->with('footerServices', Service::active()->limit(6)->get());
        });
    }
}
