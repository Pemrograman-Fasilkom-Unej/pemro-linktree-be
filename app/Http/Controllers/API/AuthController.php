<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|max:255",
            "email" => "required|email|email:dns|max:255|unique:users,email",
            "password" => "required|min:8",
            "confirm_password" => "required|min:8",
        ]);

        if($request->password === $request->confirm_password)
        {
            $data = $request->only("name", "email", "password", "confirm_password");
            $data["password"] = bcrypt($request->password);
            $user = User::create($data);
            $new_user = [
                "user" => $user,
            ];
            return ResponseFormatter::success($new_user, "User berhasil registrasi", 200);
        }
        return ResponseFormatter::error("Password dan Konfirmasi password kurang tepat", 400);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email|email:dns|exists:users,email",
            "password" => "required|min:8"
        ]);

        if(auth()->attempt($request->only("email", "password")))
        {
            $user = auth()->user();
            $token = $user->createToken(env("SANCTUM_KEY"))->plainTextToken;
            $logged_user = [
                'user' => $user,
                'token' => $token
            ];

            return ResponseFormatter::success($logged_user, "User berhasil login", 200);
        }
        return ResponseFormatter::error("User gagal login", 401);
    }
    
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return ResponseFormatter::success(null, "Berhasil Logout");
    }
}
