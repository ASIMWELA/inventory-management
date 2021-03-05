<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;


class UserController extends Controller
{
    //

    public function getAllUsers(): \Illuminate\Http\JsonResponse
    {

        $users = User::all();

        return response()->json([
            'users'=>$users
        ]);
    }

    public function getUser($userName){
        $user = User::where('userName', '=', $userName)->first();

        return response()->json([
           "userData"=>$user
        ]);
    }
    public function registerUser(UserRequest $user){

        $newUser = new User;

        $newUser->firstName=$user->firstName;
        $newUser->lastName=$user->lastName;
        $newUser->userName=$user->userName;
        $newUser->email=$user->email;
        $newUser->password= bcrypt($user->password);
        $newUser->save();

        return response()->json([
            'status'=>'ok',
            'message'=>'user saved',
        ], 201);
    }

    public function registerAdmin(UserRequest $user){

        $newUser = new User;

        $newUser->firstName=$user->firstName;
        $newUser->lastName=$user->lastName;
        $newUser->userName=$user->userName;
        $newUser->email=$user->email;
        $newUser->password= bcrypt($user->password);
        $newUser->isAdmin=true;
        $newUser->save();

        return response()->json([
            'status'=>'ok',
            'message'=>'Admin saved',
        ], 201);
    }

    public function login(LoginRequest $request){
        $input = $request->only('userName', 'password');

        $jwt_token = null;
        if (!$jwt_token = auth('api')->attempt($input)) {
            return response()->json([
                'success' => 'error',
                'message' => 'Invalid userName or Password',
            ], 403);
        }

        $user = $this->getAuthenticatedUser();

        return response()->json([
            'status' => 'ok',
            'token' => $jwt_token,
            'userData'=>$user
        ]);
    }

    public function getAuthenticatedUser(){
        return auth('api')->user();
    }

}
