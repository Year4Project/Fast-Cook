<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Faker\Factory as Faker;

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
            // Validating user input
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
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ], 400);
            }

            // Create a new user
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'user_type' => 3,
            ]);

            // Generate token with a long expiration time
            $veryLargeTTL = 52560000; // 100 years in minutes
            JWTAuth::factory()->setTTL($veryLargeTTL);

            $token = JWTAuth::fromUser($user);

            // Get the current time in UTC and add the TTL (in seconds)
            $expirationTimeInSeconds = time() + ($veryLargeTTL * 60); // Convert minutes to seconds

            // Convert expiration time to Cambodian time (ICT, UTC+7)
            $expirationTimeInICT = Carbon::createFromTimestamp($expirationTimeInSeconds, 'UTC')
                ->setTimezone('Asia/Phnom_Penh')
                ->toDateTimeString(); // Format as a string

            return response()->json([
                'status' => true,
                'message' => 'User created and logged in successfully',
                'data' => [
                    'token' => $token,
                    'user' => $user,
                    'token_expires_at' => $expirationTimeInICT // Adding token expiration time to the response
                ],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }



    // public function temporaryAccount(Request $request)
    // {
    //     try {
    //         // Generate random values
    //         $faker = \Faker\Factory::create();
            
    //         // Create user with generated values
    //         $user = User::create([
    //             'first_name' => $faker->firstName,
    //             'last_name' => $faker->lastName,
    //             // Prepend +885 to the phone number
    //             'phone' => '+885' . substr($faker->unique()->numerify('#########'), 0, 9),
    //             'password' => Hash::make($faker->password),
    //             'user_type' => 4, // Assuming user type 4 for temporary accounts
    //             'created_at' => now(),
    //         ]);
    
    //         // Create an API token for the user
    //         $token = $user->createToken("API_TOKEN")->accessToken;
    
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User Created Successfully',
    //             'token' => $token,
    //         ], 200);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $th->getMessage()
    //         ], 500);
    //     }
    // }
    public function temporaryAccount(Request $request)
{
    try {
        // Generate random values
        $faker = Faker::create();

        // Create user with generated values
        $user = User::create([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            // Prepend +885 to the phone number
            'phone' => '+885' . substr($faker->unique()->numerify('#########'), 0, 9),
            'password' => Hash::make($faker->password),
            'user_type' => 4, // Assuming user type 4 for temporary accounts
            'created_at' => now(),
        ]);

        // Create a JWT token for the user
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $token,
        ], 200);
    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }
}
    


    public function login(Request $request)
    {
        // Data validation
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if ($token = JWTAuth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            // Retrieve the authenticated user
            $user = Auth::user();

            // Generate a remember token
            $rememberToken = Str::random(60); // Generating a random token, adjust length as needed

            // Update the user's remember_token in the database
            $user->update(['remember_token' => $rememberToken]);

            // Calculate token expiration time
            $expirationTime = Carbon::now()->addYears(10); // Token valid for 10 years

            // Convert expiration time to Cambodian time (ICT, UTC+7)
            $expirationTimeInICT = $expirationTime->setTimezone('Asia/Phnom_Penh')->toDateTimeString();

            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'data' => [
                    'token' => $token,
                    'user' => $user,
                    'remember_token' => $rememberToken, // Sending remember token in the response
                    'token_expires_at' => $expirationTimeInICT, // Adding token expiration time to the response
                ],
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Phone Number or Password',
            ], 400);
        }
    }

    // Existing methods (login, register, etc.)

    /**
     * Retrieve the authenticated user's profile.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function profile(Request $request)
    {
        try {
            // Retrieve the authenticated user
            $user = Auth::user();

            // Return user information
            return response()->json([
                'status' => true,
                'message' => 'User information retrieved successfully',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            // Handle any errors that occur
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving user information',
            ], 500);
        }
    }
    
    /**
     * Update the authenticated user's profile.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request, $id)
    {
        try {
            // Authenticate the user using JWT
            $user = Auth::user();

            // Ensure the authenticated user is the one being updated
            if ($user->id != $id) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

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
                'image_url' => $user->image_url,
                // Add more fields as needed
            ];

            return response()->json(['profile' => $profile], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
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
