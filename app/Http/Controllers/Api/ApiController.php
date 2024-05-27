<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function register(Request $request)
    {
    //user registration
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

    //user login
    public function login(Request $request){
       
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

    //user profile
    public function profile(){
        $userdata= auth()->user();
        dd($userdata);die;
        return response()->json([
            'status' => true,
            'message' => 'user profile',
            'data' => $userdata,
            'id' => auth()->user()->id
        ],200);
        //return response()->json($request->user());
    }

    //user logout
    public function logout(Request $request)
    {
        $user = $request->user();
        //dd($user->tokens());die;
        // Revoke all tokens issued to the user
        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

}
