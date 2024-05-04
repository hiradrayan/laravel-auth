@php use App\Models\User\UserMeta; @endphp
@extends('layouts.auth')

@section('title')
    اطلاعات کاربر
@endsection

@section('content')
    <div class="w-lg-500px bg-body rounded shadow-sm p-5 p-lg-15 mx-auto">

        <form class="form w-100" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">تکمیل اطلاعات</h1>
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark" for="first_name">نام</label>
                <input id="first_name"
                       type="text"
                       name="first_name"
                       autocomplete="off"
                       data-lpignore="true"
                       class="form-control form-control-lg form-control-solid @error('first_name') is-invalid @enderror"
                       value="{{ old('first_name') ?? ($user ? $user->first_name : '') }}"
                       required
                />
                @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark" for="last_name">نام خانوادگی</label>
                <input id="last_name"
                       type="text"
                       name="last_name"
                       autocomplete="off"
                       class="form-control form-control-lg form-control-solid @error('last_name') is-invalid @enderror"
                       value="{{ old('last_name') ?? ($user ? $user->last_name : '') }}"
                       required
                />
                @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark" for="gender">جنسیت</label>
                <select id="gender"
                        name="gender"
                        required
                        class=" form-select form-select-solid">
                    <option value="m" {{ old('gender') == 'm' ? 'selected' : ($user && $user->gender == 'm' ? 'selected' : '') }} >آقا</option>
                    <option value="f" {{ old('gender') == 'f' ? 'selected' : ($user && $user->gender == 'f' ? 'selected' : '') }}>خانم</option>
                </select>
                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>


            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark" for="birthday">تاریخ تولد</label>
                <input id="birthday"
                       type="text"
                       name="birthday"
                       autocomplete="off"
                       required
                       class="form-control form-control-lg form-control-solid  persian-datepicker text-left @error('birthday') is-invalid @enderror"
                       value="{{ old('birthday') ?? ($user ? j_date($user->birthday,'Y/m/d') : '')  }}"
                />
                @error('birthday') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>


            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark @error('province')  is-invalid @enderror" for="province">استان</label>
                <select id="province"
                        name="province"
                        required
                        class=" form-select form-select-solid basic-select2">
                    <option value=""  disabled selected>انتخاب کنید</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}" {{ old('province') == $province->id ? 'selected' : ($user && $user->province_id == $province->id ? 'selected' : '') }} >{{ $province->title }}</option>
                    @endforeach
                </select>
                @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark @error('city')  is-invalid @enderror" for="city">شهر</label>
                <select id="city"
                        name="city"
                        required
                        class=" form-select form-select-solid basic-select2">
                    <option value=""  disabled selected>انتخاب کنید</option>
                </select>
                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>


            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark" for="job">شغل</label>
                <select id="job"
                        name="job"
                        required
                        class=" form-select form-select-solid basic-select2">
                    <option value="" selected disabled>انتخاب کنید...</option>
                    @foreach(UserMeta::JOBS as $key => $title)
                        <option value="{{ $key }}" {{ old('job') == $key ? 'selected' : ($job == $key ? 'selected' : '') }} >{{ $title }}</option>
                    @endforeach
                </select>
                @error('job') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark" for="education_degree">مدرک تحصیلی</label>
                <select id="education_degree"
                        name="education_degree"
                        required
                        class=" form-select form-select-solid">
                    <option value="" selected disabled>انتخاب کنید...</option>
                    @foreach(UserMeta::EDUCATION_DEGREES as $key => $title)
                        <option value="{{ $key }}" {{ old('education_degree') == $key ? 'selected' : ($degree == $key ? 'selected' : '') }} >{{ $title }}</option>
                    @endforeach
                </select>
                @error('education_degree') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <x-form-field.input-text
                divClass="mb-10"
                label="تصویر کارت ملی"
                type="file"
                name="national_card"
                value=""
                accept="image/png, image/gif, image/jpeg"
                labelClass="fs-6 fw-bolder text-dark"
                :required="isset($nationalCard) && $nationalCard ? false : true"
            />

            @if (isset($nationalCard) && $nationalCard)
                <img src="{{ asset('storage/'.$nationalCard->url) }}" class="mw-150px mb-10">
            @endif


            <x-form-field.input-text
                divClass="mb-10"
                label="تصویر کارت پرسنلی"
                type="file"
                name="personnel_card"
                value=""
                accept="image/png, image/gif, image/jpeg"
                labelClass="fs-6 fw-bolder text-dark"
                :required="isset($personnelCard) && $personnelCard ? false : true"
            />

            @if (isset($personnelCard) && $personnelCard)
                <img src="{{ asset('storage/'.$personnelCard->url) }}" class="mw-150px mb-10">
            @endif

            @if (!Auth::user())
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
            @endif

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
            getProvinceCities(province_id,'onChange');

        });


        $(document).ready(function () {
            var province_id = $('#province').val();

            if (province_id) {
                getProvinceCities(province_id,'onReady');
            }

            $('.basic-select2').select2();
        });

        function getProvinceCities (province_id, eventType) {
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

                if (eventType == 'onReady') {
                    oldCity = '{{ old('city') ?? ($user ? $user->city_id : '') }}';
                    if (oldCity) {
                        $("#city").val(oldCity);
                        $("#city").trigger('change');
                    }
                }
            });

        }

    </script>


    <script src="{{ asset('assets/plugins/persian-datepicker/persian-date.js') }}"></script>
    <script src="{{ asset('assets/plugins/persian-datepicker/persian-datepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/persian-datepicker/load-persian-datepicker.js') }}"></script>

@endsection
