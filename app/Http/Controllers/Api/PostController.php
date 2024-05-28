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
    //user registration
    public function store(Request $request)
    {
    $user_id= $request->userid;
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'userid' => 'required|integer|exists:users,id',
        ]);

        $post = post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->userid,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Add Content successful',
        ],200);
    }

    //get all post
    public function index(){
        $posts= post::all();
        if(post::count() > 0)
        {
            return response()->json([
                'status' => true,
                'message' => 'post',
                'data' => $posts,
                //'id' => auth()->user()->id
            ],200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'no post',
                'data' => [],
            ],200);
        }
    }

    //get single post
    public function show($id){
        $post = post::find($id);
        if($post)
        {
            return response()->json([
                'status' => true,
                'message' => 'post',
                'data' => $user,
            ],200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid user',
                'data' => [],
            ],200);
        }
    }

    //update post 
    public function update(Request $request)
    {
        $postid= $request->postid;
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'postid' => 'required|integer|exists:posts,id',
        ]);
        post::where('id', $postid)->update([
            'title' => $request->title,
            'content' => $request->content
        ]);
        return response()->json([
            'status' => true,
            'message' => 'update post successfuly',
        ],200);
    }

    public function destroy(Post $post, $id)
    {
        $post = post::find($id);
        if($post)
        {
            $post->delete();
            return response()->json([
                'status' => true,
                'message' => 'delete post successfuly',
            ],200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid user',
                'data' => [],
            ],200);
        }
    }
}
