<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Laravel API",
 *         description="API Documentation for Laravel API",
 *         @OA\Contact(
 *             email="admin@example.com"
 *         )
 *     ),
 *     @OA\Server(
 *         url="http://localhost:8000/api",
 *         description="Local server"
 *     ),
  
 * )
 */
class ApiController extends Controller
{
    /**
     * @OA\Post(
     *     path="/user-registration",
     *     summary="Register a new user",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */

    //user registration
    public function register(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'registration successful',
                'token' => $user->createToken('api-token')->plainTextToken
            ],200);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured post',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * @OA\Post(
     *     path="/user-login",
     *     summary="Login user",
     *     description="Authenticate user and return a token",
     *     operationId="loginUser",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="token", type="string", example="Bearer token")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     * )
     */
    //user login
    public function login(Request $request){
       try{
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['message' => 'Invalid login details'], 401);
            }

            $user = User::where('email', $request->email)->firstOrFail();

            return response()->json([
                'status' => true,
                'message' => 'user login successful',
                'token' => $user->createToken('api-token')->plainTextToken
            ],200);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured post',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    /**
 * @OA\Get(
 *     path="/profile",
 *     summary="User profile",
 *     tags={"User"},
 *   
 *     @OA\Parameter(
 *         name="X-CSRF-TOKEN",
 *         in="header",
 *         required=true,
 *         description="Bearer {token}",
 *         @OA\Schema(
 *             type="string",
 *             example="your-csrf-token-here"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john.doe@example.com")
 *         )
 *     ),
 *     @OA\Response(response=400, description="Bad Request"),
 *     @OA\Response(response=401, description="Unauthorized")
 * )
 */

    //user profile
    public function profile(){
        try{
            $userdata= auth()->user();
            dd($userdata);die;
            return response()->json([
                'status' => true,
                'message' => 'user profile',
                'data' => $userdata,
                'id' => auth()->user()->id
            ],200);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured post',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    //user logout
    public function logout(Request $request)
    {
        try{
            $user = $request->user();
            //dd($user->tokens());die;
            // Revoke all tokens issued to the user
            $user->tokens()->delete();

            return response()->json(['message' => 'Logged out successfully']);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured post',
                'error' => $e->getMessage()
            ], 400);
        }
    }

}
