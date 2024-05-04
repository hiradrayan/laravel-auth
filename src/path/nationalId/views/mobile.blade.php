@extends('layouts.auth')

@section('title')
    ورود - ثبت‌نام
@endsection

@section('content')
    <div class="w-lg-500px bg-body rounded shadow-sm p-5 p-lg-15 mx-auto">

        <form class="form w-100" novalidate="novalidate" action="{{ route('auth.mobile') }}" method="POST">
            @csrf
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">ورود</h1>
                <div class="text-muted fw-bold fs-7 mb-5">شماره تلفن همراه مربوط به «{{ fa_num($national_id) }}»</div>
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark" for="date">شماره تلفن همراه</label>
                <input id="mobile"
                       type="text"
                       name="mobile"
                       autocomplete="off"
                       placeholder="09_________"
                       maxlength="11"
                       class="form-control form-control-lg form-control-solid text-ltr @error('mobile') is-invalid @enderror"
                       value="{{ old('mobile') }}"
                       autofocus
                       pattern="[0-9]*" inputmode="numeric"
                />
                @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="text-center">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">ادامه</span>
                </button>
            </div>
        </form>
    </div>
@endsection
