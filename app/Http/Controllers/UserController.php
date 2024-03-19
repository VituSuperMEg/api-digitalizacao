<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $user = new User([
            'name' => $request['name'],
            'login' => $request['login'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $user->save();

        return response()->json(['message' => 'User created successfully'], 201);
    }
}
