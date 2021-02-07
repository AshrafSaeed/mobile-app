<?php
namespace App\Repositories\Subscription;

interface SubscriptionRepositoryImplement {
	
	public function create($request);

	public function validation($request);
	
	public function status();

}