<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
                    'first_name' => 'required|string|min:2|max:50',
                    'last_name' => 'required|string|min:2|max:50',
                    'phone' => 'required|string|max:10|unique:users,phone',
                    'password' => 'required|string|min:6|max:50|confirmed',
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

    public function temporaryAccount(Request $request)
    {
        try {
            // Generate random values or use defaults
            $faker = \Faker\Factory::create();

            // Create user with generated or default values
            $user = User::create([
                'first_name' => $request->filled('first_name') ? $request->first_name : $faker->firstName,
                'last_name' => $request->filled('last_name') ? $request->last_name : $faker->lastName,
                'phone' => $request->filled('phone') ? $request->phone : $faker->unique()->phoneNumber,
                'password' => $request->filled('password') ? Hash::make($request->password) : Hash::make($faker->password),
                'user_type' == 4, // Assuming user type 3 for temporary accounts
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'data' => ['token' => $user->createToken("API_TOKEN")->accessToken, "user" => $user],
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
    // public function login(Request $request)
    // {
    //     // Data validation
    //     $request->validate([
    //         "phone" => "required",
    //         "password" => "required"
    //     ]);
    
    //     // Attempt to authenticate the user
    //     if ($token = JWTAuth::attempt([
    //         "phone" => $request->phone,
    //         "password" => $request->password
    //     ])) {
    //         // Retrieve the authenticated user
    //         $user = Auth::user();
    
    //         // Generate a remember token
    //         $rememberToken = Str::random(60); // Generating a random token, adjust length as needed
    
    //         // Update the user's remember_token in the database
    //         $user->update(['remember_token' => $rememberToken]);
    
    //         // Extend the expiration time of the JWT token to a distant future
    //         JWTAuth::factory()->setTTL(525600); // 1 year in minutes
    
    //         // Get the expiration time of the token
    //         $expirationTime = time() + (JWTAuth::factory()->getTTL() * 60); // Convert minutes to seconds
    
    //         return response()->json([
    //             "status" => true,
    //             "message" => "User logged in successfully",
    //             'data' => [
    //                 "token" => $token,
    //                 "user" => $user,
    //                 "remember_token" => $rememberToken, // Sending remember token in the response
    //                 "token_expires_at" => $expirationTime // Adding token expiration time to the response
    //             ],
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             "status" => false,
    //             "message" => "Invalid Phone Number or Password"
    //         ], 400);
    //     }
    // }

    public function login(Request $request)
{
    // Data validation
    $request->validate([
        "phone" => "required",
        "password" => "required"
    ]);

    // Attempt to authenticate the user
    if ($token = JWTAuth::attempt([
        "phone" => $request->phone,
        "password" => $request->password
    ])) {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Generate a remember token
        $rememberToken = Str::random(60); // Generating a random token, adjust length as needed

        // Update the user's remember_token in the database
        $user->update(['remember_token' => $rememberToken]);

        // Extend the expiration time of the JWT token to a distant future
        JWTAuth::factory()->setTTL(525600); // 1 year in minutes

        // Get the expiration time of the token in UTC
        $expirationTime = time() + (JWTAuth::factory()->getTTL() * 60); // Convert minutes to seconds

        // Convert expiration time to Cambodian time (ICT, UTC+7)
        $expirationTimeInICT = \Carbon\Carbon::createFromTimestamp($expirationTime, 'UTC')
                             ->setTimezone('Asia/Phnom_Penh')
                             ->toDateTimeString(); // Format as a string

        return response()->json([
            "status" => true,
            "message" => "User logged in successfully",
            'data' => [
                "token" => $token,
                "user" => $user,
                "remember_token" => $rememberToken, // Sending remember token in the response
                "token_expires_at" => $expirationTimeInICT // Adding token expiration time to the response
            ],
        ], 200);
    } else {
        return response()->json([
            "status" => false,
            "message" => "Invalid Phone Number or Password"
        ], 400);
    }
}

    

    // public function profile(Request $request)
    // {
    //     try {
    //         return response()->json(['success' => true, 'data' => JWTAuth::user()]);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }

    public function profile()
    {
        try {
            // Retrieve the token from the request headers
            $token = JWTAuth::parseToken();

            // Attempt to authenticate the user using the token
            $user = $token->authenticate();

            if ($user) {
                return response()->json([
                    'success' => true,
                    'data' => $user
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function updateProfile(Request $request)
    {
        try {
            // Dump and die to inspect the request data
            // dd($request->all());

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
