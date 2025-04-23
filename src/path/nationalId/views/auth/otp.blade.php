@extends('layouts.auth')

@section('title')
    ورود - ثبت‌نام
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
            <form class="form w-100" novalidate="novalidate" action="{{ route('auth.otp') }}" method="POST">
                @csrf
                <div class="text-center mb-10">
                    {{--  <h1 class="text-dark mb-3">ورود</h1>  --}}
                    <div class="auth-text-password mb-5">کدفعال‌سازی برای موبایل «{{ fa_num($mobile) }}»</div>
                </div>

                <div class="fv-row mb-10">
                    {{--  <label class="form-label fs-6 fw-bolder text-dark" for="otp"></label>  --}}
                    <input id="otp"
                        type="text"
                        name="otp"
                        maxlength="4"
                        autocomplete="off"
                        style="font-size: 20px"
                        placeholder="کد‌فعال سازی"
                        class="auth-login-input  text-lg-center @error('otp') is-invalid @enderror"
                        value="{{ old('otp') ?? (env('APP_ENV') == 'local' ? session()->get('otp') : '')  }}"
                        autofocus
                        pattern="[0-9]*" inputmode="numeric"
                    />
                    @error('otp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="text-nowrap text-center mt-lg-5 mb-lg-5 auth-text-password">
                    <div id="resend_sms_timer_block">
                        ارسال مجدد کد تا <span id="resend_sms_timer" style="display: inline-block; width: 30px;"> ۱:۵۹ </span>  دیگر
                    </div>

                    <a href="javascript:resendOtp()" style="display: none; cursor: pointer!important;" id="resend_sms_link" class="font-weight-bold" >دریافت مجدد کد تایید</a>
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

@section('scripts')
    <script>

        var mobile = '{{ $mobile }}';
        var resendOtpUrl = '{{ route('api.auth.otp.resend') }}';
        var csrf_token = '{{ csrf_token() }}';

        $(document).ready(function (){
            toastr.options = {
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-bottom-left",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }


            timerCountDown();
        });

    </script>

    <script src="{{ asset('assets/js/custom/resend-otp.js') }}"></script>
@endsection
