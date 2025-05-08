<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
use App\Services\OpenAIService;
use GuzzleHttp\Client;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
public function register()
{
    $this->app->singleton(OpenAIService::class, function ($app) {
        return new OpenAIService(new Client());
    });
}


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
        //Schema::defaultStringLength(191);
    }
}
