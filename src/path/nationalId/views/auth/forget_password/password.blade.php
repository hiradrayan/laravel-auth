@extends('layouts.auth')

@section('title')
    ورود
@endsection

@section('content')
    <div class="login-box-long">
        <div class="row justify-content-center align-items-center">
            <div class="col-6 auth-login-btn">ورود به سایت</div>
        </div>


        <div class="auth-login-box">
            <div class="text-center auth-login-logo">
                <img src="{{ asset('assets/img/user-avatar.svg') }}" alt="">
            </div>

            <form class="form w-100" novalidate="novalidate" action="{{ route('auth.forget.password') }}" method="POST">
                @csrf
                <div class="text-center mb-10">
                    {{--  <h1 class="text-dark mb-3">ورود</h1>  --}}
                    <div class="auth-text-password fs-7 mb-5">کلمه عبور مربوط به «{{ fa_num($national_id) }}»</div>
                </div>

                <div class="mb-5 fv-row" data-kt-password-meter="true">
                    <!--begin::Wrapper-->
                    <div class="mb-1">
                        <!--begin::Tags-->
                        {{--  <label class="form-label fw-bolder text-dark fs-6">کلمه عبور</label>  --}}
                        <!--end::Tags-->
                        <!--begin::Input wrapper-->
                        <div class="position-relative mb-3">
                            <input class="auth-login-input" minlength="8" type="password" placeholder="کلمه عبور" name="password" autocomplete="off" />
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                <i class="fa fa-eye-slash fs-2"></i>
                                <i class="fa fa-eye fs-2 d-none"></i>
                            </span>
                        </div>
                        <!--end::Input wrapper-->
                        <!--begin::Meter-->
                        <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                        </div>
                        <!--end::Meter-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Hint-->
                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                    <div class="auth-forget-text">از 8 حرف یا بیشتر با ترکیبی از حروف ، اعداد و نمادها استفاده کنید.</div>
                    <!--end::Hint-->
                </div>


                <div class="fv-row mb-5">
                    {{--  <label class="form-label fs-6 fw-bolder text-dark" for="date"></label>  --}}
                    <input id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        autocomplete="off"
                        placeholder="تکرار کلمه عبور"
                        class="auth-login-input @error('password_confirmation') is-invalid @enderror"
                    />
                    @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="text-center">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-sm final-auth-login-btn">
                        <span class="indicator-label">ورود</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
