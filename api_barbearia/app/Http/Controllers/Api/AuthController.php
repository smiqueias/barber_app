<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\JWTGuard;
use Illuminate\Support\Facades\Validator;





class AuthController extends Controller {


    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request): JsonResponse {


        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $token = auth('api')->JWTAuth::attempt($validator->validated());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }


    public function register(Request $request): JsonResponse {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
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



    public function logout(): JsonResponse {
        auth('api')->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }


    public function refresh(): JsonResponse {
        return $this->createNewToken(auth('api')->refresh());
    }


    public function userProfile(): JsonResponse {
        return response()->json(auth()->user());
    }


    protected function createNewToken($token): JsonResponse{
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }
}
