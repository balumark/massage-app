<?php

namespace App\Providers;

use App\Persistence\Repositories\Implements\EloquentServiceAppointmentRepository;
use App\Persistence\Repositories\Implements\EloquentServiceRepository;
use Illuminate\Support\ServiceProvider;
use App\Persistence\Repositories\Interfaces\UserRepository;
use App\Persistence\Repositories\Implements\EloquentUserRepository;
use App\Persistence\Repositories\Interfaces\ServiceAppointmentRepository;
use App\Persistence\Repositories\Interfaces\ServiceRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(ServiceRepository::class, EloquentServiceRepository::class);
        $this->app->bind(ServiceAppointmentRepository::class, EloquentServiceAppointmentRepository::class);
    }
}
