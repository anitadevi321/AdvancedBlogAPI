<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    public function register(Request $request)
    {
    //user registration
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = post::create([
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
}
