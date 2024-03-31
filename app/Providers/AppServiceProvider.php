<?php

namespace App\Providers;

use App\Helper\ApiJsonResponser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('ApiJsonResponser',function(){
            return new ApiJsonResponser();
       });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
