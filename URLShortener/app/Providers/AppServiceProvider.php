<?php

namespace App\Providers;

use App\Models\Url;
use App\Policies\UrlPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    // REGISTER POLICIES 
    protected $policies = [
        Url::class => UrlPolicy::class,
    ];

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
        //
    }

}
