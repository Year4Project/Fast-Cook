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


    public function updateUser(Request $request, $id)
    {
        try {
            // Get the authenticated user
            $authenticatedUser = Auth::user();
            
            // Check if the authenticated user matches the requested user ID
            if ($authenticatedUser->id != $id) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            // Find the user by ID
            $userToUpdate = User::findOrFail($id);
    
            // Validate the incoming request data
            $request->validate([
                'first_name' => 'string|max:255',
                'last_name' => 'string|max:255',
                'email' => 'email|max:255|unique:users,email,' . $id,
                'phone' => 'string|max:20',
                'image_url' => 'url|nullable',
                // Add validation rules for other fields as needed
            ]);
    
            // Update user data
            $userToUpdate->update([
                'first_name' => $request->input('first_name', $userToUpdate->first_name),
                'last_name' => $request->input('last_name', $userToUpdate->last_name),
                'email' => $request->input('email', $userToUpdate->email),
                'phone' => $request->input('phone', $userToUpdate->phone),
                'image_url' => $request->input('image_url', $userToUpdate->image_url),
                // Update other fields as needed
            ]);
    
            // Optionally, you can refresh the user model to get the updated data
            $userToUpdate = $userToUpdate->fresh();
    
            // Return the updated profile
            $profile = [
                'id' => $userToUpdate->id,
                'first_name' => $userToUpdate->first_name,
                'last_name' => $userToUpdate->last_name,
                'email' => $userToUpdate->email,
                'phone' => $userToUpdate->phone,
                'image' => $this->getImageBase64($userToUpdate->image_url),
                // Add more fields as needed
            ];
    
            return response()->json(['profile' => $profile], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
