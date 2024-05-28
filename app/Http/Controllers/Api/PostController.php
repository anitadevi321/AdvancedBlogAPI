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
        try{
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
    catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'An error occured post',
            'error' => $e->getMessage()
        ], 400);
    }
    }

    //get all post
    public function index(){
        try{
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
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured post',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    //get single post
    public function show($id){
        try{
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
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured post',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    //update post 
    public function update(Request $request)
    {
        try{
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
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured post',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy(Post $post, $id)
    {
        try{
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
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured post',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
