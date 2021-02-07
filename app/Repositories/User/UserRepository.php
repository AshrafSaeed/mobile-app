<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryImplement 
{ 

    /**
     * login / signup user.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */

    public function login($request) 
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $token = Auth::user()->createToken('mobile-app')->accessToken;

            return [['user' => Auth::user(), 'token' => $token], 200];
        }

        return [["message" => 'The provided credentials do not match our records.'], 422];

    }

    /**
     * register new user.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */

    public function register($request) 
    {
        try {

            $user = User::create($request->all());
            $user->device()->create($request->all());

            $token = $user->createToken('mobile-app')->accessToken;
            
            return [['user' => $user, 'token' => $token], 200];


        } catch (Exception $e) {
            return ['unable to register user. '.$e->getMessage(), $e->getCode()];
        }
    }
  
}