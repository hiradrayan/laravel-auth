@extends('layouts.auth')

@section('title')
    اطلاعات تکمیلی
@endsection

@section('content')
    <div class="w-lg-500px bg-body rounded shadow-sm p-5 p-lg-15 mx-auto">

        <form class="form w-100" action="{{ route('auth.user_extra_info') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">    اطلاعات تکمیلی</h1>
            </div>

            <x-form-field.input-text
                divClass="mb-10"
                label="تصویر کارنامه"
                type="file"
                name="karnameh"
                value=""
                accept="image/png, image/gif, image/jpeg"
                labelClass="fs-6 fw-bolder text-dark"
                :required="isset($karnameh) && $karnameh ? false : true"
            />

            @if (isset($karnameh) && $karnameh)
                <img src="{{ asset('storage/'.$karnameh->url) }}" class="mw-150px mb-10" style="margin-top: -30px;">
            @endif


            <x-form-field.input-text
                divClass="mb-10"
                label="تصویر معرفینامه"
                type="file"
                name="moarefinameh"
                value=""
                accept="image/png, image/gif, image/jpeg"
                labelClass="fs-6 fw-bolder text-dark"
                :required="isset($moarefinameh) && $moarefinameh ? false : true"
            />

            @if (isset($moarefinameh) && $moarefinameh)
                <img src="{{ asset('storage/'.$moarefinameh->url) }}" class="mw-150px mb-10" style="margin-top: -30px;">
            @endif


            <div class="text-center">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">ادامه</span>
                </button>
            </div>
        </form>
    </div>
@endsection
