<div id="kt_header" class="header">
    <div class="container-fluid d-flex flex-stack">
        <div class="d-flex align-items-center me-5">
            @if (str_contains(request()->route()->getName(),'admin.') ||
                 str_contains(request()->route()->getName(),'user.') ||
                 str_contains(request()->route()->getName(),'tickets.') ||
                 str_contains(request()->route()->getName(),'instructor.')

                 )
            <div class="d-lg-none btn btn-icon btn-active-color-white w-30px h-30px ms-n2 me-3" id="kt_aside_toggle">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
                        <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
                    </svg>
                </span>
            </div>
            @endif
            <!--begin::Logo-->
            <a href="{{ route('home') }}">
                <img alt="لوگو {{ $partner ? isset($partner->options['settings']['title']) ? $partner->options['settings']['title'] : 'موسسه بامداد' : 'موسسه بامداد' }}" src="@if (isset($partner->options['settings']['logo_id'])) {{ asset(image_url($partner->options['settings']['logo_id'], '100_30')) }} @else {{ asset('assets/img/admin-logo-2.jpg') }} @endif" class="h-25px h-lg-30px" />
            </a>
            <!--end::Logo-->

        </div>
        <!--begin::header-->
        <div class="d-flex align-items-center flex-shrink-0">

            <!--begin::user-->
            <div class="d-flex align-items-center ms-1" id="kt_header_user_menu_toggle">

                @auth()
                    {{--  @if(!is_granted('ROLE_INSTRUCTOR'))
                        <a href="{{ route('teacher.register.tracking') }}" class="btn btn-outline-success btn-sm ms-2 d-none d-sm-block">ثبت‌نام استاد</a>
                    @endif  --}}
                    <!--begin::user info-->
                <div class="btn btn-flex align-items-center bg-hover-white bg-hover-opacity-10 py-2 px-2 px-md-3" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                    <!--begin::name-->
                    <div class=" d-md-flex flex-column align-items-end justify-content-center me-2 me-md-4">
{{--                        <span class="fs-8 fw-bold badge badge-danger lh-1 mb-1">ادمین</span>--}}
                        <span class=" fs-8 fw-bolder lh-1">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                    </div>
                    <!--end::name-->
                    <div class="symbol symbol-30px symbol-md-40px">
                        <img src="/{{ user_image_url(Auth::user()) }}" alt="کاربر" />
                    </div>
                </div>
                <!--end::user info-->

                <!--begin::user account menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4  w-275px" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50px me-5">
{{--                                <img alt="user avatar" src="{{ asset('assets/img/avatar-sample.jpg') }}" />--}}
                            </div>
                            <!--end::Avatar-->
                            <!--begin::username-->
                            <div class="d-flex flex-column">
                                <div class="fw-bolder d-flex align-items-center fs-5">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                                    <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">@if (is_granted('ROLE_ADMIN')) مدیر @endif</span></div>
                                <a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{ auth()->user()->national_id }}</a>
                            </div>
                            <!--end::username-->
                        </div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        @if (is_granted('ROLE_ADMIN'))
                            <a href="{{ route('admin.dashboard') }}" class="menu-link px-5">داشبورد مدریت</a>
                            <a href="{{ route('admin.instructors.list') }}" class="menu-link px-5">مدرسین</a>
                            @module(App\Models\Admin\Module::COURSE)
                            <a href="{{ route('admin.courses') }}" class="menu-link px-5">دوره‌ها</a>
                            @endmodule
                            @module(App\Models\Admin\Module::TUTORSHIP)
                            <a href="{{ route('admin.tutorships.index') }}" class="menu-link px-5">کلاس‌ها</a>
                            @endmodule
                        @elseif (is_granted('ROLE_INSTRUCTOR'))
                            <a href="{{ route('instructor.dashboard',['user_id' => Auth::user()->id]) }}" class="menu-link px-5">داشبورد</a>
                        @elseif (is_granted('ROLE_TRUSTED_USER'))
                            <a href="{{ route('trusted-user.dashboard',['user_id' => Auth::user()->id]) }}" class="menu-link px-5">داشبورد من</a>
                        @elseif (is_granted('ROLE_USER'))
                            <a href="{{ route('user.dashboard') }}" class="menu-link px-5">داشبورد من</a>
                        @endif
                    </div>
                    <div class="separator my-2"></div>

                    @if (!is_granted('ROLE_TRUSTED_USER'))
                    <div class="menu-item px-5">
                        <a href="{{ route('user.profile.show') }}" class="menu-link px-5" disabled="">پروفایل من</a>
                    </div>
                    @endif
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
{{--                    <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start">--}}
{{--                        <a href="#" class="menu-link px-5">--}}
{{--                            <span class="menu-title">اشتراک من</span>--}}
{{--                            <span class="menu-arrow"></span>--}}
{{--                        </a>--}}

{{--                        <!--begin::Menu separator-->--}}
{{--                        <div class="separator my-2"></div>--}}
{{--                        <!--end::Menu separator-->--}}

{{--                        <!--begin::Menu sub-->--}}
{{--                        <div class="menu-sub menu-sub-dropdown w-175px py-4">--}}
{{--                            <!--begin::Menu item-->--}}
{{--                            <div class="menu-item px-3">--}}
{{--                                <a href="/courses" class="menu-link px-5">دوره‌ها</a>--}}
{{--                            </div>--}}
{{--                            <!--end::Menu item-->--}}
{{--                        </div>--}}
{{--                        <!--end::Menu sub-->--}}
{{--                    </div>--}}
                    <!--end::Menu item-->


                    <!--begin::Menu item-->
                    <div class="menu-item">
                        <div class="menu-content">
                            <a href="/logout" class="menu-link px-5">خروج</a>
                        </div>
                    </div>
                    <!--end::Menu item-->
                </div>

                    <!--end::user account menu-->
                @else
                    <a href="{{ route('auth.login') }}" class="btn btn-primary btn-sm">ورود / ثبت‌نام</a>
                    {{--  <a href="{{ route('auth.login') }}?type=teacher" class="btn btn-outline-success btn-sm ms-2 d-none d-sm-block">ثبت‌نام استاد</a>  --}}
                @endauth

            </div>
            <!--end::user -->
        </div>
    </div>
</div>
