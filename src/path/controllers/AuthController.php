<?php

namespace Authentication\path\controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Authentication\path\requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth::login');
    }

    public function loginPost(LoginRequest $request)
    {
        $user = User::where('national_id', $request->nationalId)->first();

        if (!$user)
        {
            return back()->with('message','کاربری بااین کد‌ملی یافت نشد.');
        }

        if(!Hash::check($request->password, $user->password))
        {
            return back()->with('message','رمز ورود وارد شده اشتباه است.');
        }

        Auth::Login($user);

        return redirect()->route('admin.home');
    }
}