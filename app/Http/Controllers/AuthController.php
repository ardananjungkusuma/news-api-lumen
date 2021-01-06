<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $apiToken = base64_encode(Str::random(40));
        $password = Hash::make($request->password);

        $register = User::create([
            "name" => $name,
            "email" => $email,
            "api_token" => $apiToken,
            "password" => $password
        ]);

        if ($register) {
            return response()->json([
                "status" => true,
                "message" => "Register Success",
                "data" => $register
            ], 201);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Register Failed",
            ], 400);
        }
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if (Hash::check($password, $user->password)) {
            return response()->json([
                "status" => true,
                "messages" => "Successfully Login",
                "data" => $user
            ], 201);
        } else {
            return response()->json([
                "status" => false,
                "messages" => "Login Failed"
            ]);
        }
    }
}
