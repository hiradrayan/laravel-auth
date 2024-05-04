<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl">
<head>
    @include ('auth::includes.app.head')
</head>

<body id="kt_body" class="bg-body">
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed bg-light">
        <div class="d-flex flex-center flex-column flex-column-fluid p-5 pb-lg-20">
            <a href="" class="mb-12">
                <img alt="Logo" src="{{ asset('assets/img/bamdad-logo.png') }}" class="h-40px"/>
            </a>

            @if (Session::has('alert') && Session::get('alert'))
                    @foreach (Session::get('alert') as $type => $message)
                        <div class="alert alert-{{ $type }}"> {{ $message }}</div>
                    @endforeach
            @endif


            @yield('content')

        </div>
        <!--begin::Footer-->
        <div class="d-flex flex-center flex-column-auto p-10">
            <div class="d-flex align-items-center fw-bold fs-6">
                <a href="" class="text-muted text-hover-primary px-2 fs-7">درباره‌ی ما</a>
                <a href="" class="text-muted text-hover-primary px-2 fs-7">تماس با ما</a>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/admin/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/admin/scripts.bundle.js') }}"></script>
@yield('scripts')
</body>
