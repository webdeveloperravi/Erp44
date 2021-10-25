<?php

namespace App\Http\Controllers;
use App\User;

use Validator;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
     
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'email|required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // if (! $token = auth()->attempt($validator->validated())) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }
        if (! $token =  JWTAuth::attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // if ($token = JWTAuth::attempt($validator)) {
        //     return $this->respondWithToken($token);
        // }
    
        // return response()->json(['error' => 'Unauthorized'], 401);
  
        return $this->createNewToken($token);
    }

   
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'email|required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    
    public function logout() {

        auth('api')->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

   
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

   
    public function userProfile() {
        return response()->json(auth('api')->user());
    }

    
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

}