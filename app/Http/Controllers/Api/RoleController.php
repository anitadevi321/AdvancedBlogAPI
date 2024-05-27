<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class RoleController extends Controller
{
    public function store(Request $request)
    {
    //create role
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = role::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'create role successfully',
            //'token' => $user->createToken('api-token')->plainTextToken
        ],200);
    }

     //get all role
     public function index(){
        $roles = role::all();
        if(role::count() > 0)
        {
            return response()->json([
                'status' => true,
                'message' => 'Roles',
                'data' => $roles,
                //'id' => auth()->user()->id
            ],200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'no record',
                'data' => [],
            ],200);
        }
    }

    //assignRole to user
    function assignRole(Request $request, User $user){
       // dd($request);die;
       $userid= $request->userid;
       $role_id= $request->role_id;
        $request->validate([
            'userid' => 'required|string|exists:users,id'
            //'role_id' =>'required|integer|role_id',
        ]);

        $user = User::find($userid);
        if($user)
        {
            User::where('id', $userid)->update(['role_id' => $role_id]);
            return response()->json([
                'status' => true,
                'message' => 'Assign role to user successfuly',
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid user',
            ],200);
        }
    }
}
