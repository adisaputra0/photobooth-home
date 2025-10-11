<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view("auth/login");
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username" => "required",
            "password" => "required",
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')->withErrors($validator);
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('indexAdmin');
        }

        return redirect()->route('login')->withErrors(['error' => 'Invalid email or password']);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
