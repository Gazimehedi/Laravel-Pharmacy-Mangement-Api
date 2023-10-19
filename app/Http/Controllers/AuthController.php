<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'username' => 'required|min:2',
            'password' => 'required|min:5'
        ]);
        if($validation->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validation->errors()->first()
            ],400);
        }
        $credentials = $request->only('username', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'status' => "error",
                'message' => "User credentials doesn't match!"
            ],401);
        }
        return $this->createNewToken($token);
    }
    public function createNewToken($token){
        return response()->json([
            'status'=>'success',
            'message' => 'User login successfully',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
