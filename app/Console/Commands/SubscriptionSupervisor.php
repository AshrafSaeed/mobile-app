<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;

class SubscriptionSupervisor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:supervisor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Subscription Status expire and status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get Pending Subscription 
        $subscriptions = Subscription::with('user')->where([
                            ['purchase_state', false],
                            ['created_at', now()->addDays(-1)]
                        ])->get();
        
        if($subscriptions) {
            foreach ($subscriptions as $subscription) {
                
                //Call Google/iOS API for pending subscription
                $payment = true;


                // Update Subscription into DB 
                $status = Subscription::where('user_id', $subscription->user_id)
                        ->update([
                            'purchase_state' => true,
                            'expire_at' => now()->addDays(15)
                        ]);

                $this->line('Update Subscription of User: '.$subscription->user->name.' ('.$subscription->user->email);
            }
        } else {
            $this->line('no subscription for update yet!');
        }

    }
}
