@extends('layouts.auth')

@section('title')
    ورود
@endsection

@section('content')
    <div class="w-lg-500px bg-body rounded shadow-sm p-5 p-lg-15 mx-auto">

        <form class="form w-100" novalidate="novalidate" action="{{ route('auth.password') }}" method="POST" id="form">
            @csrf
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">ورود</h1>
                <div class="text-muted fw-bold fs-7 mb-5">کلمه عبور مربوط به «{{ fa_num($national_id) }}»</div>
            </div>

            <div class="fv-row mb-2">
                <label class="form-label fs-6 fw-bolder text-dark" for="date">کلمه عبور</label>
                <input id="password"
                       type="password"
                       name="password"
                       autocomplete="off"
                       autofocus
                       class="form-control form-control-lg form-control-solid text-ltr @error('password') is-invalid @enderror"
                />
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="fv-row mb-10 d-flex justify-content-end">
                <a href="{{ route('auth.forget.national_id') }}" >«فراموشی کلمه عبور»</a>
            </div>

            <div class="text-center">
{{--                <script src='https://www.google.com/recaptcha/api.js?hl=fa'></script>--}}
                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5 g-recaptcha" data-sitekey="{{ env('RECAPTCHAV3_SITEKEY') }}" data-callback="submitForm">
                    <span class="indicator-label">ورود</span>
                </button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
{{--    <script>--}}
{{--        function submitForm(token) {--}}
{{--            document.getElementById("form").submit();--}}
{{--        }--}}
{{--    </script>--}}
@endsection
