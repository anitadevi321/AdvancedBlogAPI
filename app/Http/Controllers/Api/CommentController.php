<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\comment;
use App\Models\User;
use App\Models\post;

class CommentController extends Controller
{
    //create comment
    public function store(Request $request, Post $post)
    {
        try{
            $userid= $request->userid;
            $request->validate([
                'content' => 'required|string|max:255',
                'userid' => 'required|integer|exists:posts,user_id',
            ]);
    
           $postid= post::where('user_id', $userid)->pluck('id');
          // echo $postid[0];die;
          if($postid){
            $comment = comment::create([
                'post_id' => $postid[0],
                'user_id' => $request->userid,
                'content' => $request->content,
            ]);
           // dd($comment);die;
            return response()->json([
                'status' => true,
                'message' => 'Add Comment successfully',
            ],200);
          }
          else{
            return response()->json([
                'status' => true,
                'message' => 'post id does not exist',
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

     //get comment by post
    public function index(Post $post, $post_id)
    {
        try{
        $count = Comment::where('post_id', $post_id)->count();
       if($count > 0)
       {
            $comment= Comment::where('post_id', $post_id)->get();
            return response()->json([
                'status' => true,
                'message' => 'comments',
                'data' => $comment
            ],200);
       }
       else{
        return response()->json([
            'status' => false,
            'message' => 'no comment',
            'data' => []
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

    //get single comment
    public function show(Post $post, Comment $comment,$commentId, $postId)
    {
        try{
        $count = Comment::where('post_id', $postId)
                        ->where('id', $commentId)->count();
        if($count > 0)
        {
            $comment = Comment::where('post_id', $postId)
                                ->where('id', $commentId)->get();
            return response()->json([
                'status' => true,
                'message' => 'comments',
                'data' => $comment
            ],200);
        }
        else{
            return response()->json([
                'status' => true,
                'message' => 'no comment',
                'data' => []
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

    //update comment
    public function update(Request $request, Post $post, Comment $comment)
    {
        try{
        $post_id= $request->post_id;
        $commentId= $request->commentId;
        $validate_request= $request->validate([
            'content' => 'required|string|max:255',
            'commentId' => 'required|integer|exists:Comments,id',
            'post_id' => 'required|integer|exists:Comments,post_id',
        ]);

        if($validate_request)
        {
            $count = Comment::where('post_id', $post_id)->where('id', $commentId)->count();
            if($count > 0)
            {
            $comment = Comment::where('post_id', $post_id) ->where('id', $commentId)->update(['content' => $request->content]);           
                return response()->json([
                'status' => true,
                'message' => 'update successfuly',
                ],200);
            }
            else{
                return response()->json([
                'status' => false,
                'message' => 'invalid user',
                'data' => []
                ],200);
            }
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

    //delete comment
    public function destroy(Post $post, Comment $comment, $commentId)
    {
        try{
        $comment = Comment::find($commentId);
        if($comment)
        {
            $comment->delete();
            return response()->json([
                'status' => true,
                'message' => 'delete comment successfuly',
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