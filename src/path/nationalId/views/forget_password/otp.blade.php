@extends('layouts.auth')

@section('content')
    <div class="w-lg-500px bg-body rounded shadow-sm p-5 p-lg-15 mx-auto">

        <form class="form w-100" novalidate="novalidate" action="{{ route('auth.forget.otp') }}" method="POST">
            @csrf
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">تغییر کلمه عبور</h1>
                <div class="text-muted fw-bold fs-7 mb-5">کد فعال‌سازی برای شماره تلفن همراه زیر ارسال شد
                    <div style="direction: ltr;" >«{{ masked_mobile($mobile) }}»</div> </div>
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark" for="otp">کد فعال‌سازی</label>
                <input id="otp"
                       type="text"
                       name="otp"
                       maxlength="4"
                       autocomplete="off"
                       style="font-size: 20px"
                       placeholder="_ _ _ _"
                       class="form-control form-control-lg form-control-solid  text-lg-center @error('otp') is-invalid @enderror"
                       value="{{ old('otp') ?? (env('APP_ENV') == 'local' ? session()->get('otp') : '')  }}"
                />
                @error('otp') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="text-nowrap text-center mt-lg-5 mb-lg-5">
                <div id="resend_sms_timer_block">
                    ارسال مجدد کد تا <span id="resend_sms_timer" style="display: inline-block; width: 30px;"> ۱:۵۹ </span>  دیگر
                </div>

                <a href="javascript:resendOtp()" style="display: none; cursor: pointer!important;" id="resend_sms_link" class="font-weight-bold" >دریافت مجدد کد تایید</a>
            </div>


            <div class="text-center">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">تایید</span>
                </button>
            </div>
        </form>
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
