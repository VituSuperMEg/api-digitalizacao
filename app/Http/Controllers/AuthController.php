<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(["login", "password"]);

        $user = User::where('login', $credentials['login'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = auth()->login($user);

        return response()->json([
            "data" => [
                "token" => $token,
                "token_type" => "bearer",
                "expires_in" => auth()->factory()->getTTL() * 60
            ]
        ]);
    }
}
