@extends('layouts.auth')

@section('title')
   تغییر کلمه عبور
@endsection
@section('content')
    <div class="login-box">
        <div class="row justify-content-center align-items-center">
            <div class="col-6 auth-login-btn">تغییر کلمه عبور</div>
        </div>

        <div class="auth-login-box">
            <div class="text-center auth-login-logo">
                <img src="{{ asset('assets/img/user-avatar.svg') }}" alt="">
            </div>
            <form class="form w-100" novalidate="novalidate" action="" method="POST">
                @csrf

                <div class="fv-row mb-10">
                    {{--  <label class="form-label fs-6 fw-bolder text-dark" for="date"></label>  --}}
                    <input id="national_id"
                        type="text"
                        name="national_id"
                        autocomplete="off"
                        placeholder="کدملی"
                        maxlength="10"
                        required
                        class="form-control form-control-lg form-control-solid text-ltr @error('national_id') is-invalid @enderror"
                        value="{{ old('national_id') ?? $national_id }}"
                    />
                    @error('national_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
