<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;

class JWTAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Register User endpoint
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|between2,100',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|confirmed|string:min:6'
        ]);

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'messages' => 'Successfully registered',
            'user' => $user
        ],201);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if(! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' =>'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }
}
