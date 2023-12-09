<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function register(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'first_name' => 'required|string|min:2|max:100',
                'last_name'=> 'required|string|min:2|max:100',
                'email'=> 'required|string|email|max:100|unique:users',
                'password' => 'required|string|min:6|max:100|confirmed',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 400);
            }

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name'=> $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_tyep' => 3,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'user' => $user,
                'token' => $user->createToken("API TOKEN")->accessToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */

     

     public function login(Request $request){

        // data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // JWTAuth
        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        if(!empty($token)){
            $user = Auth::user();
            return response()->json([
                "status" => true,
                'userData' =>$user,
                "message" => "User logged in succcessfully",
                "token" => $token
            ]);
        }else{
            return response()->json([
            "status" => false,
            "message" => "Invalid details"
        ]);
        }
        
    }


    // User Profile (GET)
    public function profile()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json($user);
    }

    // To generate refresh token value
    public function refreshToken(){

        $newToken = auth()->refresh();

        return response()->json([
            "status" => true,
            "message" => "New access token",
            "token" => $newToken
        ]);
    }

    // User Logout (GET)
    public function logout(Request $request)
    {
        $token = JWTAuth::getToken();
        
        if ($token) {
            try {
                JWTAuth::invalidate($token);

                // Optionally, you can also blacklist the token
                // JWTAuth::manager()->getBlacklist()->add($token);
            } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                // Token has expired
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                // Token is invalid
            }
        }

        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

}