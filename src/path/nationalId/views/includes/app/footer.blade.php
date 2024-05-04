    <div class="d-flex flex-column flex-root">
    <div class="mb-0">

        <div class="landing-curve landing-dark-color">
            <svg viewBox="15 -1 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 48C4.93573 47.6644 8.85984 47.3311 12.7725 47H1489.16C1493.1 47.3311 1497.04 47.6644 1501 48V47H1489.16C914.668 -1.34764 587.282 -1.61174 12.7725 47H1V48Z" fill="currentColor"></path>
            </svg>
        </div>

        <div class="landing-dark-bg">
            <div class="container">
                <div class="row py-5 py-lg-10">
                    <div class="col-lg-6 pe-lg-16 mb-10 mb-lg-0">
                        <div class="rounded landing-dark-border p-9 mb-10">
                            <h5 class="text-white">می‌خواهید مستقیما با {{ isset($partner->options['settings']['title']) ? $partner->options['settings']['title'] : 'سامانه بامداد' }} در ارتباط باشید؟</h5>
                            <span class="fw-normal fs-4 text-gray-700">ایمیل
									<a href="mailto:{{ isset($partner->options['settings']['email']) ? $partner->options['settings']['email'] : 'info@bamdadedu.com' }}" class="text-white opacity-50 text-hover-primary">{{ isset($partner->options['settings']['email']) ? $partner->options['settings']['email'] : 'info@bamdadedu.com' }}</a></span>
                        </div>
                    </div>

                    <div class="col-lg-6 ps-lg-16">
                        <div class="d-flex justify-content-center">

                            <div class="d-flex fw-bold flex-column me-20">
                                <h5 class="fw-bolder text-gray-400 mb-6">دسترسی سریع</h5>
                                <a href="" class="text-white opacity-50 text-hover-primary  mb-6">خانه</a>
                                {{--  <a href="{{ route('auth.login') }}?type=teacher" class="text-white opacity-50 text-hover-primary  mb-6">ثبت‌نام استاد</a>  --}}
                                {{--  <a href="{{ Auth::user() ? route('trusted-user.tracking',['user_id' => Auth::user()->id]) : route('auth.login',['type' => 'trusted_user']) }}" class="text-white opacity-50 text-hover-primary  mb-6">ثبت‌نام معتمد</a>  --}}
                                {{--  <a href="https://bamdadedu.com/shop/" class="text-white opacity-50 text-hover-primary  mb-6">فروشگاه</a>  --}}
{{--                                <a href="#" class="text-white opacity-50 text-hover-primary  mb-6">بلاگ</a>--}}
                                <a href="{{ route('faq') }}" class="text-white opacity-50 text-hover-primary  mb-6">سوالات متداول</a>
                            </div>

                            <div class="d-flex fw-bold flex-column me-20">
                                <h5 class="fw-bolder text-white mb-6">با {{ isset($partner->options['settings']['title']) ? $partner->options['settings']['title'] : 'سامانه بامداد' }}</h5>
                                {{--  <a href="https://bamdadedu.com/introduce-colleague/" class="text-white opacity-50 text-hover-primary  mb-6">همکاران</a>
                                <a href="https://bamdadedu.com/consultants/" class="text-white opacity-50 text-hover-primary  mb-6">مشاوران</a>  --}}
                                <a href="{{ isset($partner->options['settings']['instagram']) ? $partner->options['settings']['instagram'] : 'https://www.instagram.com/lmsbamdad' }}" class="text-white opacity-50 text-hover-primary  mb-6" ><i class="fa-brands fa-square-instagram mx-2"></i>اینستاگرام</a>
                                <a href="{{ isset($partner->options['settings']['telegram']) ? $partner->options['settings']['telegram'] : 'https://t.me/lmsbamdad' }}" class="text-white opacity-50 text-hover-primary  mb-6"><i class="fa-brands fa-telegram mx-2"></i>تلگرام</a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="landing-dark-separator"></div>

            <div class="container">
                <div class="d-flex flex-column flex-md-row flex-stack py-3 py-lg-5">
                    <div class="d-flex align-items-center order-2 order-md-1">
                        <a href="/">
                            <img alt="Logo" src="{{ asset('assets/img/admin-logo.png') }}" class="h-15px h-md-20px" />
                        </a>
                        <span class="mx-5 fs-6 fw-bold text-gray-600 pt-1" href="#">© 2022  {{ isset($partner->options['settings']['title']) ? $partner->options['settings']['title'] : 'سامانه بامداد' }}</span>
                    </div>
                    <ul class="menu menu-gray-600 menu-hover-primary fw-bold fs-6 fs-md-5 order-1 mb-5 mb-md-0">
                        <li class="menu-item">
                            <a class="text-white" href="" target="_blank" class="menu-link px-2 fs-7">درباره‌ی ما</a>
                        </li>
                        <li class="menu-item mx-5">
                            <a class="text-white" href="" target="_blank" class="menu-link px-2 fs-7">تماس با ما</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('includes.admin.scroll-top')

</div>
