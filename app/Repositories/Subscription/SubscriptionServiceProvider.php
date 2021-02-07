<?php

namespace App\Repositories\Subscription;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Subscription\SubscriptionRepository;
use App\Repositories\Subscription\SubscriptionRepositoryImplement;

class SubscriptionServiceProvider extends ServiceProvider
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
            SubscriptionRepositoryImplement::class, 
            SubscriptionRepository::class 
        );
    }
}