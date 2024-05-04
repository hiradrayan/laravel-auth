@extends('auth::layouts.auth')

@section('title')
    ورود - ثبت‌نام
@endsection
@section('content')
    <div class="w-lg-500px bg-body rounded shadow-sm p-5 p-lg-15 mx-auto">

        <form class="form w-100" novalidate="novalidate" action="{{ route('auth.national_id') }}" method="POST">
            @csrf
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">ورود</h1>
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark" for="date">کدملی</label>
                <input id="national_id"
                       type="text"
                       name="national_id"
                       autocomplete="off"
                       placeholder="__________"
                       maxlength="10"
                       autofocus
                       required
                       class="form-control form-control-lg form-control-solid text-ltr @error('national_id') is-invalid @enderror"
                       value="{{ old('national_id') }}"
                       pattern="[0-9]*" inputmode="numeric"
                />
                @error('national_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="text-center">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">ادامه</span>
                </button>
            </div>
        </form>
    </div>
@endsection
