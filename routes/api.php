<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\SubscriptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

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

