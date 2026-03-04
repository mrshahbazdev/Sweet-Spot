<?php

namespace App\Providers;

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
        $appUrl = config('app.url');
        if (!empty($appUrl) && $appUrl !== 'http://localhost') {
            \Illuminate\Support\Facades\URL::forceRootUrl($appUrl);
            if (\Illuminate\Support\Str::startsWith($appUrl, 'https://')) {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            }
        }
    }
}
