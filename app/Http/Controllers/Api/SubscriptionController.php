<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidationRequest;
use App\Http\Requests\SubscriptionRequest;
use App\Repositories\Subscription\SubscriptionRepositoryImplement;

class SubscriptionController extends Controller
{

    protected $subscription;
    
    /**
     * Create subscription instance.

     * @param  App\Repositories\Subscription\SubscriptionRepositoryImplement; $subscription
     * @return void
     */

    public function __construct(SubscriptionRepositoryImplement $subscription ) {
        
        return $this->subscription = $subscription;

    }

    /**
     * create subscription.
     *
     * @param  App\Http\Requests\SubscriptionRequest;  $SubscriptionRequest
     * @return \Illuminate\Http\Response
     */

    public function create(SubscriptionRequest $request)
    {        
        list($contenet, $code) = $this->subscription->create($request);
        return response($contenet, $code);

    }


    /**
     * validate subscription.
     *
     * @param  App\Http\Requests\SubscriptionRequest;  $SubscriptionRequest
     * @return \Illuminate\Http\Response
     */

    public function validation(ValidationRequest $request)
    {        
        list($contenet, $code) = $this->subscription->validation($request->all());
        return response($contenet, $code);

    }

    /**
     * get subscription status.
     *
     * @param  Current Login User
     * @return \Illuminate\Http\Response
     */

    public function status()
    {
        list($contenet, $code) = $this->subscription->status();
        return response()->json($contenet, $code);
    }
}
