@extends('layouts.auth')

@section('title')
    اطلاعات کاربر
@endsection

@section('content')
    <div class="w-lg-500px bg-body rounded shadow-sm p-5 p-lg-15 mx-auto">

        <form class="form w-100" action="{{ route('auth.user_info') }}" method="POST">
            @csrf
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">تکمیل اطلاعات</h1>
            </div>
            @if (is_array($registerFields) && array_key_exists('first_name', $registerFields))
                <div class="fv-row mb-10">
                    <label class="form-label fs-6 fw-bolder text-dark" for="first_name">نام</label>
                    <input id="first_name"
                        type="text"
                        name="first_name"
                        autocomplete="off"
                        data-lpignore="true"
                        class="form-control form-control-lg form-control-solid @error('first_name') is-invalid @enderror"
                        value="{{ old('first_name') }}"
                    />
                    @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            @endif

            @if (is_array($registerFields) && array_key_exists('last_name', $registerFields))
                <div class="fv-row mb-10">
                    <label class="form-label fs-6 fw-bolder text-dark" for="last_name">نام خانوادگی</label>
                    <input id="last_name"
                        type="text"
                        name="last_name"
                        autocomplete="off"
                        class="form-control form-control-lg form-control-solid @error('last_name') is-invalid @enderror"
                        value="{{ old('last_name') }}"
                    />
                    @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            @endif

            @if (is_array($registerFields) && array_key_exists('gender', $registerFields))
                <div class="fv-row mb-10">
                    <label class="form-label fs-6 fw-bolder text-dark" for="gender">جنسیت</label>
                    <select id="gender"
                            name="gender"
                            class=" form-select form-select-solid">
                        <option value="m" {{ old('gender') == 'm' ? 'selected' : '' }} >پسر</option>
                        <option value="f" {{ old('gender') == 'f' ? 'selected' : '' }}>دختر</option>
                    </select>
                    @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            @endif

            @if (is_array($registerFields) && array_key_exists('province_and_city', $registerFields))
                <div class="fv-row mb-10">
                    <label class="form-label fs-6 fw-bolder text-dark @error('province')  is-invalid @enderror" for="province">استان</label>
                    <select id="province"
                            name="province"
                            class=" form-select form-select-solid basic-select2">
                        <option value=""  disabled selected>انتخاب کنید</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}" {{ old('province') == $province->id ? 'selected' : '' }} >{{ $province->title }}</option>
                        @endforeach
                    </select>
                    @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="fv-row mb-10">
                    <label class="form-label fs-6 fw-bolder text-dark @error('city')  is-invalid @enderror" for="city">شهر</label>
                    <select id="city"
                            name="city"
                            class=" form-select form-select-solid basic-select2">
                        <option value=""  disabled selected>انتخاب کنید</option>
                    </select>
                    @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            @endif

            {{--  <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark" for="grade">مقطع</label>
                <select id="grade"
                        name="grade"
                        class=" form-select form-select-solid @error('grade') is-invalid @enderror">
                    <option value=""  disabled selected>انتخاب کنید</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" {{ old('grade') == $grade->id ? 'selected' : '' }} >{{ $grade->title }}</option>
                    @endforeach
                </select>
                @error('grade') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark" for="major">رشته</label>
                <select id="major"
                        name="major"
                        class=" form-select form-select-solid @error('major') is-invalid @enderror">
                    <option value={null}  disabled selected>انتخاب کنید</option>
                </select>
                @error('major') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>  --}}

            @if (is_array($registerFields) && array_key_exists('school', $registerFields))
                <div class="fv-row mb-10">
                    <label class="form-label fs-6 fw-bolder text-dark" for="school_name">نام مدرسه</label>
                    <input id="school_name"
                        type="text"
                        name="school_name"
                        autocomplete="off"
                        data-lpignore="true"
                        class="form-control form-control-lg form-control-solid @error('school_name') is-invalid @enderror"
                        value="{{ old('school_name') }}"
                    />
                    @error('school_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            @endif

            @if (is_array($registerFields) && array_key_exists('invitation_code', $registerFields))
                <div class="fv-row mb-10">
                    <label class="form-label fs-6 fw-bolder text-dark" for="recommender_user_hash">کد معرف</label>
                    <input id="recommender_user_hash"
                        type="text"
                        name="recommender_user_hash"
                        autocomplete="off"
                        data-lpignore="true"
                        class="form-control text-ltr form-control-lg form-control-solid @error('recommender_user_hash') is-invalid @enderror"
                        value="{{ old('recommender_user_hash') ?? request()->session()->get('recommender_user_hash') }}"
                    />
                    @error('recommender_user_hash') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            @endif

            <div class="mb-10 fv-row" data-kt-password-meter="true">
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



            <div class="text-center">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">ادامه</span>
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $('#province').on('change',function (){
            var province_id = $(this).val();
            getProvinceCities(province_id);

        });

        $(document).ready(function () {
            var province_id = $('#province').val();

            if (province_id) {
                getProvinceCities(province_id);
            }

            $('.basic-select2').select2();

        });

        function getProvinceCities (province_id) {
            $.post('{{ route('get_province_cities') }}',{
                'province_id': province_id
            }).done(function (data){
                $('#city')
                    .empty()
                    .append("<option value='' selected disabled >انتخاب شهر</option>");

                var cities = data.result.cities;

                cities.map(city => {
                    $("#city").append(new Option(city.title,city.id));
                });

                oldCity = '{{ old('city') }}';
                if (oldCity) {
                    $("#city").val('{{ old('city') }}');
                    $("#city").trigger('change');
                }

            })

        }
    </script>
@endsection
