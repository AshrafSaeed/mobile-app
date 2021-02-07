<?php

namespace App\Repositories\User;

use Illuminate\Support\ServiceProvider;

use App\Repositories\User\UserRepositoryImplement;
use App\Repositories\User\UserRepository;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        
        $this->app->bind(
            UserRepositoryImplement::class, 
            UserRepository::class 
        );
    }
}