
### About Mobile APP


## installation

``` 
composer install

// add database name in .env file 

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mobile-app
DB_USERNAME=root
DB_PASSWORD=

// after instalation run DB migration 

php artisan migrate

// Install Passport for OAuth2 

php artisan passport:install

```

## Subscriptions Route

```
Route::group(['middleware' => ['json.response']], function () {

    // public routes
    Route::post('/login', [AuthController::class, 'login'])->name('login.api');
    Route::post('/register', [AuthController::class, 'register'])->name('register.api');

});

Route::group(['middleware' => ['auth:api', 'json.response']], function () {

    // logout 
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.api');

	Route::group(['prefix' => '/subscription'], function () {
	    // create subscription 
	    Route::post('/create', [SubscriptionController::class, 'create'])->name('subscription.create');

	    // create subscription 
	    Route::post('/validate', [SubscriptionController::class, 'validation'])->name('subscription.validate');

	    // subscription status 
	    Route::get('/status', [SubscriptionController::class, 'status'])->name('subscription.status');
	});

});
```
