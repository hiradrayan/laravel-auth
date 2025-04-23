@extends('auth::layouts.auth')

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
            <form class="form w-100" novalidate="novalidate" action="{{ route('auth.national_id') }}" method="POST">
                @csrf

                <div class="fv-row mb-10">
                    {{--  <label class="form-label fs-6 fw-bolder text-dark" for="date"></label>  --}}
                    <input id="national_id"
                        type="text"
                        name="national_id"
                        autocomplete="off"
                        placeholder="کدملی"
                        maxlength="10"
                        autofocus
                        required
                        class="text-rtl @error('national_id') is-invalid @enderror auth-login-input"
                        value="{{ old('national_id') }}"
                        pattern="[0-9]*" inputmode="numeric"
                    />
                    @error('national_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="text-left">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-sm final-auth-login-btn">
                        <span class="indicator-label">ورود به سایت</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
