<?php

namespace App\Repositories\Subscription;

use App\Models\Subscription;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SubscriptionRepository implements SubscriptionRepositoryImplement 
{ 
    /**
     * create user subscription.
     *
     * @param  App\Http\Requests\SubscriptionRequest;  $SubscriptionRequest
     * @return \Illuminate\Http\Response
    */

    public function create($request) 
    {
        try {

            // here we will call (Google/iOS) In App Subscription and send date for patment process
            $payment = true;

            // store subscrioton in case of payment complete 
            $subscription = Subscription::updateOrCreate(
                ['user_id' => Auth::id()],
                $request->only(['user_id', 'order_id', 'package_name', 'product_id'])
            );

            return [$subscription, 200];

        } catch (Exception $e) {

            return [__('unable to create subscription. '.$e->getMessage()), $e->getCode()];
        }
    }

    /**
     * validate user subscription.
     *
     * @param  App\Http\Requests\SubscriptionRequest;  $SubscriptionRequest
     * @return \Illuminate\Http\Response
    */

    public function validation($request) 
    {
        try {

            $isEvenOrOdd = Str::islastdigitevenorodd($request['recept_id']);

            if($isEvenOrOdd) {            
                $subscription = Subscription::where('user_id', Auth::id())
                    ->update([
                        'purchase_state' => true,
                        'expire_at' => now()->addDays(15)
                    ]);

                return [$subscription, 200];
            }

            return [false, 404];

        } catch (Exception $e) {

            return [__('unable to validate subscription. '.$e->getMessage()), $e->getCode()];
        }
    }


    /**
     * get subscription validate.
     *
     * @param  App\Http\Requests\SubscriptionRequest;  $SubscriptionRequest
     * @return \Illuminate\Http\Response
    */

    public function status() 
    {
        try {

            $subscription = Subscription::findOrFail(Auth::id())->first();
            return [$subscription, 200];

        } catch (Exception $e) {

            return [__('unable to get subscription status. '.$e->getMessage()), $e->getCode()];
        }

    }

}