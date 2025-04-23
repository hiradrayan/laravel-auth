@extends('layouts.auth')

@section('title')
    ورود
@endsection

@section('content')
    <div class="login-box-password">
        <div class="row justify-content-center align-items-center">
            <div class="col-6 auth-login-btn">ورود به سایت</div>
        </div>

        <div class="auth-login-box">
            <div class="text-center auth-login-logo">
                <img src="{{ asset('assets/img/user-avatar.svg') }}" alt="">
            </div>
            <form class="form w-100" novalidate="novalidate" action="{{ route('auth.password') }}" method="POST" id="form">
                @csrf
                <div class="text-center mb-10">
                    <div class="mb-5 auth-text-password">کلمه عبور مربوط به «{{ fa_num($national_id) }}»</div>
                </div>

                <div class="fv-row mb-2">
                    {{--  <label class="form-label fs-6 fw-bolder text-dark" for="date"></label>  --}}
                    <input id="password"
                        type="password"
                        name="password"
                        autocomplete="off"
                        autofocus
                        placeholder="کلمه عبور"
                        class="text-rtl @error('password') is-invalid @enderror auth-login-input"
                    />
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="fv-row mb-10 d-flex justify-content-start align-items-center mt-10">
                    <i class="fa fa-key me-2"></i>
                    <a class="auth-forget-text" href="{{ route('auth.forget.national_id') }}" > رمز عبور را فراموش کرده‌اید؟</a>
                </div>

                <div class="text-center">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-sm final-auth-login-btn">
                        <span class="indicator-label">ورود به سایت</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
{{--    <script>--}}
{{--        function submitForm(token) {--}}
{{--            document.getElementById("form").submit();--}}
{{--        }--}}
{{--    </script>--}}
@endsection
