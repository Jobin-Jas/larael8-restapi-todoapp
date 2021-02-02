<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $response = [];

            $response = [
                'token' => $user->createToken('todo')->accessToken,
                'name' => $user->name
            ];

            return response()->json($response, 200);
        } else {
            return response()->json(['error' => 'unauthenticated'], 401);
        }
    }


    public function register(RegisterRequest $request)
    {
        $input = $request->only(['email', 'name', 'password']);
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        return response()->json([
            'token' => $user->createToken('todo')->accessToken,
            'name' => $user->name,
            'email' => $user->email,
        ], 200);
    }

    public function taskList()
    {
        $user = Auth::user();
        $response = [
            'status' => 'ok',
            'tasks' => $user->tasks()->get()
        ];
        return response()->json($response);
    }
}
