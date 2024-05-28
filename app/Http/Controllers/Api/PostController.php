<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    public function store(Request $request, Post $post)
    {
    //user registration
    return $request; die;
    $user_id= $request->userid;
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'userid' => 'required|integer|exists:users,id',
        ]);

        $user = post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->userid,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Add Content successful',
           // 'token' => $user->createToken('api-token')->plainTextToken
        ],200);
    }
}
