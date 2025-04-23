@extends('layouts.auth')

@section('title')
    ورود - ثبت‌نام
@endsection

@section('content')
    <div class="login-box">
        <div class="row justify-content-center align-items-center">
            <div class="col-6 auth-login-btn">ورود به سایت</div>
        </div>

        <div class="auth-login-box">
            <div class="text-center auth-login-logo">
                <img src="{{ asset('assets/img/user-avatar.svg') }}" alt="">
            </div>
            <form class="form w-100" novalidate="novalidate" action="{{ route('auth.mobile') }}" method="POST">
                @csrf
                <div class="text-center mb-10">
                    {{--  <h1 class="text-dark mb-3">ورود</h1>  --}}
                    <div class="auth-text-password mb-5">شماره تلفن همراه مربوط به «{{ fa_num($national_id) }}»</div>
                </div>

                <div class="fv-row mb-10">
                    {{--  <label class="form-label fs-6 fw-bolder text-dark" for="date"></label>  --}}
                    <input id="mobile"
                        type="text"
                        name="mobile"
                        autocomplete="off"
                        placeholder="شماره تلفن همراه"
                        maxlength="11"
                        class="auth-login-input text-rtl @error('mobile') is-invalid @enderror"
                        value="{{ old('mobile') }}"
                        autofocus
                        pattern="[0-9]*" inputmode="numeric"
                    />
                    @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="text-center">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-sm final-auth-login-btn">
                        <span class="indicator-label">ادامه</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
