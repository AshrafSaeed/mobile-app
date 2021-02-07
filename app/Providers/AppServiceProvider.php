<?php
namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        
        // Extend String macro to get Last digit Even or Odd
        Str::macro('islastdigitevenorodd', function ($content) {
            
            $lastDigit = substr($content, -1); // get last didgit of string
            return (intval($lastDigit) % 2 !== 0) ? false : true;

        });

    }
}
