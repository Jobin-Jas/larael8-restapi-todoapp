<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    //
    public function login(Request $req)
    {
        $credentials = $req->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $response = [];

            $response = [
                'token' => $user->createToken('todo')->accessToken,
                'name' => $user->name
            ];

            return response()->json($response, 200);
        } else {
            /**
             * Responses should be given properly
             */
            return response()->json(['error' => 'unauthenticated'], 401);
        }
    }
    public function register(Request $req)
    {
        $validate = Validator::make(
            $req->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|alpha_num|min:6',
            ]
        );
        if ($validate->fails()) {
            return response()->json(['validation_error' => $validate->errors()]);
        }

        // $req->all() may lead to security issues
        $input = $req->only(['email', 'name', 'password']);
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        return response()->json([
            'token' => $user->createToken('todo')->accessToken,
            'name' => $user->name,
            'email' => $user->email,
        ], 200);
    }

    /**
     * use camelCase for function names
     * and snake_case for variables
     */
    public function taskList()
    {
        $user = Auth::user();
        $response = [
            'status' => 'ok',
            'tasks' => $user->tasks
        ];
        return response()->json($response);
    }
}
