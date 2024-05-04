<?php

namespace Authentication\path\nationalId\controllers;

use App\Http\Controllers\Controller;
use Authentication\path\nationalId\Requests\Auth\NationalIdRequest;
use App\Models\User;
use Authentication\path\nationalId\Requests\Auth\OtpRequest;
use Authentication\path\nationalId\Requests\Auth\ConfirmedPasswordRequest;

class ForgetPasswordController extends Controller
{
    public function getNationalId ()
    {
        $national_id = \Session::get('national_id', null);

        return view('auth.forget_password.national_id',[
            'national_id' => $national_id
        ]);
    }

    public function postNationalId (NationalIdRequest $request)
    {
        $national_id = en_num($request->national_id);

        \Session::put('national_id', $national_id);

        $user = User::where('national_id', '=', $national_id)->first();

        if (!$user) {
            return back()->withErrors(['national_id' => 'کاربری با این کدملی یافت نشد.']);
        }

        $authController = new AuthController();
        $authController->sendOtp($user->mobile);

        return redirect()->route('auth.forget.otp');
    }

    public function getOtp ()
    {
        $national_id = \Session::get('national_id');
        if (!$national_id) {
            return redirect()->route('auth.forget.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
        }

        $user = User::where('national_id', '=', $national_id)->first();
        if (!$user) {
            return redirect()->route('auth.forget.national_id')->with('alert.warning','کاربری با این مشخصات یافت نشد');
        }

        return view('auth.forget_password.otp',[
            'mobile' => $user->mobile,
        ]);
    }

    public function postOtp (OtpRequest $request)
    {
        $national_id = \Session::get('national_id');
        if (!$national_id) {
            return redirect()->route('auth.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
        }

        $user = User::where('national_id', '=', $national_id)->first();
        if (!$user) {
            return redirect()->route('auth.forget.national_id')->with('alert.warning','کاربری با این مشخصات یافت نشد');
        }

        $otp = en_num($request->otp);

        $correctOtp = \Session::get('otp');

        if ($otp != $correctOtp) {
            return back()->withErrors(['otp'=>'کد تایید وارد شده صحیح نیست']);
        }

        \Session::put("is_{$national_id}_verified",true);

        return redirect()->route('auth.forget.password');

    }

    public function getPassword ()
    {
        $national_id = \Session::get('national_id');
        if (!$national_id) {
            return redirect()->route('auth.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
        }

        $user = User::where('national_id', '=', $national_id)->first();
        if (!$user) {
            return redirect()->route('auth.forget.national_id')->with('alert.warning','کاربری با این مشخصات یافت نشد');
        }

        $is_verified = \Session::get("is_{$national_id}_verified",false);

        if (!$is_verified) {
            return back()->withErrors(['otp'=>'لطفا کد تایید دریافتی را وارد فرمایید.']);
        }

        return view('auth.forget_password.password',[
            'national_id' => $national_id,
        ]);


    }

    public function postPassword (ConfirmedPasswordRequest $request)
    {
        $national_id = \Session::get('national_id');
        if (!$national_id) {
            return redirect()->route('auth.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
        }

        $user = User::where('national_id', '=', $national_id)->first();
        if (!$user) {
            return redirect()->route('auth.forget.national_id')->with('alert.warning','کاربری با این مشخصات یافت نشد');
        }

        $is_verified = \Session::get("is_{$national_id}_verified",false);

        if (!$is_verified) {
            return back()->withErrors(['otp'=>'لطفا کد تایید دریافتی را وارد فرمایید.']);
        }

        $user->password = \Hash::make($request->password);
        $user->save();

        return redirect()->route('auth.national_id')->with('alert.success','کلمه عبور شما با موفقیت تغییر یافت');
    }
}
