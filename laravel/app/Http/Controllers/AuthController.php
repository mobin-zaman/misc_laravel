<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
        ]);

        $token = auth()->login($user);

        return $this->responseWithToken($token);
    }

    public function login(Request $request) {
        $credentials = $request->only(['email', 'password']);

        //if you can not get the token from the attempt method
        if(!$token = auth()-> attempt($credentials)) {
            return response()->json(['error'=> 'Unauthorized'], 401);
        }

        return $this->responseWithToken($token);
    }

    protected function responseWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}
