<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\Log;

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
            $validateUser = Validator::make(
                $request->all(),
                [
                    'first_name' => 'required|string|min:2|max:100',
                    'last_name' => 'required|string|min:2|max:100',
                    'password' => 'required|string|min:6|max:100|confirmed',
                    'phone' => 'required|string|max:10|unique:users,phone',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 400);
            }

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                // 'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_tyep' => 3,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'data' => ['token' => $user->createToken("API TOKEN")->accessToken, "user" => $user],
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

     public function login(Request $request)
     {
         // data validation
         $request->validate([
             "phone" => "required",
             "password" => "required"
         ]);

         // JWTAuth with a longer expiration time (e.g., 1 year) or set it to null for unlimited duration
         $token = JWTAuth::attempt([
             "phone" => $request->phone,
             "password" => $request->password
         ], [
             'exp' => now()->addYear()->timestamp, // Set expiration to 1 year (adjust as needed) or set to null
         ]);

         if (!empty($token)) {
             $user = Auth::user();
             return response()->json([
                 "status" => true,
                 "message" => "User logged in successfully",
                 'data' => ["token" => $token, "user" => $user],
             ]);
         } else {
             return response()->json([
                 "status" => false,
                 "message" => "Invalid details"
             ]);
         }
     }

    // User Profile
    public function profile(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            // You can customize the data you want to return in the profile
            $profile = [
                'id'    => $user->id,
                'first_name'  => $user->first_name,
                'last_name'  => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'image'      => $this->getImageBase64($user->image_url),
                // Add more fields as needed
            ];

            return response()->json(['profile' => $profile], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            // Dump and die to inspect the request data
            dd($request->all());

            // Authenticate the user using JWT
            $user = JWTAuth::parseToken()->authenticate();

            // Validate the incoming request data
            $request->validate([
                'first_name' => 'string|max:255',
                'last_name' => 'string|max:255',
                'email' => 'email|max:255|unique:users,email,' . $user->id,
                'phone' => 'string|max:20',
                'image_url' => 'url|nullable',
            ]);

            // Update user data
            $user->update([
                'first_name' => $request->input('first_name', $user->first_name),
                'last_name' => $request->input('last_name', $user->last_name),
                'email' => $request->input('email', $user->email),
                'phone' => $request->input('phone', $user->phone),
                'image_url' => $request->input('image_url', $user->image_url),
                // Add more fields as needed
            ]);

            // Optionally, you can refresh the user model to get the updated data
            $user = $user->fresh();

            // Return the updated profile
            $profile = [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'image' => $this->getImageBase64($user->image_url),
                // Add more fields as needed
            ];

            return response()->json(['profile' => $profile], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    private function getImageBase64($imageUrl)
    {
        try {
            // Check if the image URL is not empty
            if (!empty($imageUrl)) {
                // Fetch the image content
                $imageContent = file_get_contents($imageUrl);

                // Convert the image content to base64
                $base64Image = base64_encode($imageContent);

                return $base64Image;
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }





    // To generate refresh token value
    public function refreshToken()
    {

        $newToken = Auth::refresh();

        return response()->json([
            "status" => true,
            "message" => "New access token",
            "token" => $newToken
        ]);
    }

    public function logout(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Invalidate the JWT token
            $token = JWTAuth::getToken();

            if ($token) {
                try {
                    JWTAuth::invalidate($token);
                } catch (TokenInvalidException $e) {
                    // Handle token invalidation exception if needed
                    return response()->json(['error' => 'Failed to invalidate token'], 500);
                }
            }

            // Logout the user
            Auth::logout();

            return response()->json(['message' => 'Successfully logged out']);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }
}
