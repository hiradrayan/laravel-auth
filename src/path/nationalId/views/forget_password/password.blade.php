@extends('layouts.auth')

@section('title')
    ورود
@endsection

@section('content')
    <div class="w-lg-500px bg-body rounded shadow-sm p-5 p-lg-15 mx-auto">

        <form class="form w-100" novalidate="novalidate" action="{{ route('auth.forget.password') }}" method="POST">
            @csrf
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">ورود</h1>
                <div class="text-muted fw-bold fs-7 mb-5">کلمه عبور مربوط به «{{ fa_num($national_id) }}»</div>
            </div>

            <div class="mb-5 fv-row" data-kt-password-meter="true">
                <!--begin::Wrapper-->
                <div class="mb-1">
                    <!--begin::Tags-->
                    <label class="form-label fw-bolder text-dark fs-6">کلمه عبور</label>
                    <!--end::Tags-->
                    <!--begin::Input wrapper-->
                    <div class="position-relative mb-3">
                        <input class="form-control form-control-lg form-control-solid" minlength="8" type="password" placeholder="" name="password" autocomplete="off" />
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
                <div class="text-muted">از 8 حرف یا بیشتر با ترکیبی از حروف ، اعداد و نمادها استفاده کنید.</div>
                <!--end::Hint-->
            </div>


            <div class="fv-row mb-5">
                <label class="form-label fs-6 fw-bolder text-dark" for="date">تکرار کلمه عبور</label>
                <input id="password_confirmation"
                       type="password"
                       name="password_confirmation"
                       autocomplete="off"
                       class="form-control form-control-lg form-control-solid @error('password_confirmation') is-invalid @enderror"
                />
                @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="text-center">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">ورود</span>
                </button>
            </div>
        </form>
    </div>
@endsection
