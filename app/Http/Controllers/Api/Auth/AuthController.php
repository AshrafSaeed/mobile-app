<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\User\UserRepositoryImplement;


class AuthController extends Controller
{
	
	protected $userrepo;

	/**
     * Create a new controller instance.

     * @param  App\Repositories\User\UserRepositoryImplement; $userrepo
     * @return void
     */

    public function __construct(UserRepositoryImplement $userrepo ) {
        
        return $this->userrepo = $userrepo;

    }

	/**
     * register user with device data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function register(RegisterRequest $request) {

	    list($contect, $code) = $this->userrepo->register($request);
	    
	    return response($contect, 200);
	}

	/**
     * login user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

	public function login (LoginRequest $request) {

	    list($contect, $code) = $this->userrepo->login($request);
	    
	    return response($contect, 200);

	}

	/**
     * logout user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response $
     */

	public function logout(Request $request) {
	    $token = $request->user()->token();
	    $token->revoke();
	    return response(['message' => 'You have been successfully logged out!'], 200);
	}
}
