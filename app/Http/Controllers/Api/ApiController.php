<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
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
