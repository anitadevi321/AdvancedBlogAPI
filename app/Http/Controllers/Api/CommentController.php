<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\comment;
use App\Models\User;
use App\Models\post;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
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

    public function index(Post $post, $post_id)
    {
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

    public function show(Post $post, Comment $comment,$commentId, $postId)
    {
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


    public function update(Request $request, Post $post, Comment $comment)
    {
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
}