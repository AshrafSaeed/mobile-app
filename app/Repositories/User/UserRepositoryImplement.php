<?php
namespace App\Repositories\User;

interface UserRepositoryImplement {
	
	public function register( $request);

	public function login($request);
	
}