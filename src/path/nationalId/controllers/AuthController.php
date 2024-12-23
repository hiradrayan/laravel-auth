<?php

namespace Authentication\path\nationalId\controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Authentication\Interface\OtpSenderInterface;
use Authentication\path\models\SecurityLog;
use Authentication\path\requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Authentication\path\nationalId\Requests\Auth\NationalIdRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Authentication\path\Service\StringFunctions;
use Authentication\path\nationalId\Requests\Auth\MobileRequest;
use Authentication\path\nationalId\Requests\Auth\OtpRequest;
use Authentication\path\Service\UserAgentService;
use Authentication\path\nationalId\Requests\Auth\UserInfoRequest;

class AuthController extends Controller
{
    public function login (Request $request) {

        Session::put('back_url',$request->source);
        // Session::put('recommender_user_hash',$request->hash);

        return redirect()->route('auth.national_id');
    }

    public function logout (Request $request) {
        $flash = $request->flash;
        $currentUser = Auth::user();

        $userAgentService = new UserAgentService();
        $userAgentService->delete($currentUser);

        Session::flush();
        Auth::logout();

        if (!$flash) {
            return redirect()->route('home')->with('alert.success','شما با موفقیت خارج شدید');
        }

        return redirect()->route('home')->with($flash['type'] ?? 'alert-warning', $flash['message'] ?? '');
    }


    public function getNationalId ()
    {
        \Session::forget([
            'national_id',
            'mobile',
            'otp',
            'is_verified',
        ]);

        return view('auth::auth.national_id');
    }

    public function postNationalId (NationalIdRequest $request)
    {
        $national_id = en_num($request->national_id);

        $tenMinAgo = new \DateTime('UTC');
        $tenMinAgo->sub(new \DateInterval('PT10M'));

        \Session::put('national_id', $national_id);

        $user = User::where('national_id', '=', $national_id)->first();

        $isLocked = SecurityLog::query()
            ->where('data',$national_id)
            ->where('created_at','>=',$tenMinAgo)
            ->where('is_locked',true)
            ->count('id');

        if ($isLocked) {
            return redirect()->route('auth.national_id')->with('alert.warning','حساب شما برای مدت کوتاهی قفل شده. لطفا چند دقیقه دیگر امتحان کنید.');
        }

        if ($user) {
            return  redirect()->route('auth.password');
        }

        if (!config('authentication.registration'))
        {
            return back()->with('alert.warning', 'کاربر دسترسی های لازم را ندارد.');
        }

        return redirect()->route('auth.mobile');
    }

    public function getPassword  () {

        $national_id = \Session::get('national_id');
        if (!$national_id) {
            return redirect()->route('auth.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
        }

        $user = User::where('national_id', '=', $national_id)->first();
        if (!$user) {
            return redirect()->route('auth.mobile');
        }

        return view('auth.password',[
            'national_id' => $national_id,
        ]);

    }

    public function postPassword (Request $request)
    {

        $recaptchaVerified = false;
        $secret = env('RECAPTCHAV3_SECRET');
        $stringFunctions = new StringFunctions();

        $tenMinAgo = new \DateTime('UTC');
        $tenMinAgo->sub(new \DateInterval('PT10M'));

        $national_id = \Session::get('national_id');

        if (!$national_id) {
            return redirect()->route('auth.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
        }

        $isLocked = SecurityLog::query()
            ->where('data',$national_id)
            ->where('created_at','>=',$tenMinAgo)
            ->where('is_locked',true)
            ->count('id');

        if ($isLocked) {
            return redirect()->route('auth.national_id')->with('alert.warning','حساب شما برای مدت کوتاهی قفل شده. لطفا چند دقیقه دیگر امتحان کنید.');
        }


        $user = User::where('national_id', '=', $national_id)->first();
        if (!$user) {
            return redirect()->route('auth.mobile');
        }

        $password = $request->password;
        if (! \Hash::check($password, $user->password)) {

            $wrongPassCount = SecurityLog::query()
                ->where('data',$national_id)
                ->where('created_at','>=',$tenMinAgo)
                ->count('id');

            SecurityLog::create([
                'type'      => 'WRONG_PASSWORD',
                'data'      => $national_id,
                'user_id'   => $user->id,
                'ip'        => $stringFunctions->getRealIPAddr(request()),
                'is_locked' => $wrongPassCount >= 4,
            ]);
            return  back()->withErrors([
                'password' => 'کلمه عبور وارد شده صحیح نیست'
            ]);
        }

        $this->loginUser($user);
        return  $this->findRedirectUrl($user);

    }

    public function getMobile()
    {
        $national_id = \Session::get('national_id');
        if (!$national_id) {
            return redirect()->route('auth.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
        }

        $user = User::where('national_id', '=', $national_id)->first();
        if ($user) {
            return redirect()->route('auth.password');
        }


        return view ('auth.mobile',[
            'national_id' => $national_id,
        ]);
    }

    public function postMobile (MobileRequest $request)
    {
        $stringFunctions = new StringFunctions();
        $mobile = $stringFunctions->getMobile($request->mobile);

        $national_id = \Session::get('national_id');
        if (!$national_id) {
            return redirect()->route('auth.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
        }

        $user = User::where('national_id', '=', $national_id)->first();
        if ($user) {
            return redirect()->route('auth.password');
        }

        \Session::put('mobile',$mobile);

        $otpResult = $this->sendOtp($mobile);

        return redirect()->route('auth.otp');
    }

    public function getOtp ()
    {
        $national_id = \Session::get('national_id');
        if (!$national_id) {
            return redirect()->route('auth.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
        }

        $user = User::where('national_id', '=', $national_id)->first();
        if ($user) {
            return redirect()->route('auth.password');
        }

        $mobile = \Session::get('mobile');
        if (!$mobile) {
            return redirect()->route('auth.mobile')->with('alert.warning','لطفا شماره تلفن همراه خود را وارد فرمایید');
        }


        return view('auth.otp',[
            'mobile' => $mobile,
        ]);
    }

    public function postOtp (OtpRequest $request)
    {
        $national_id = \Session::get('national_id');
        $stringFunctions = new StringFunctions();

        if (!$national_id) {
            return redirect()->route('auth.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
        }

        $user = User::where('national_id', '=', $national_id)->first();
        if ($user) {
            return redirect()->route('auth.password');
        }

        $mobile = \Session::get('mobile');
        if (!$mobile) {
            return redirect()->route('auth.mobile')->with('alert.warning','لطفا شماره تلفن همراه خود را وارد فرمایید');
        }

        $otp = en_num($request->otp);

        $correctOtp = \Session::get('otp');

        if ($otp != $correctOtp) {

            SecurityLog::create([
                'type'       => 'WRONG_OTP',
                'data'       => $national_id,
                'user_id'    => $user ? $user->id : null,
                'ip'         => $stringFunctions->getRealIPAddr(request()),
                'description'=> $mobile,
                'parameters' => [
                    'mobile'      => $mobile,
                    'national_id' => $national_id,
                ]
            ]);

            return back()->withErrors(['otp'=>'کد تایید وارد شده صحیح نیست']);
        }

        \Session::put('is_verified',true);

        return $this->findRedirectUrl($user);
    }

    public function getUserInfo ()
    {

        $national_id = \Session::get('national_id');
        if (!$national_id) {
            return redirect()->route('auth.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
        }

        $user = User::where('national_id', '=', $national_id)->first();
        if ($user) {
            return redirect()->route('auth.password');
        }

        $mobile = \Session::get('mobile');
        if (!$mobile) {
            return redirect()->route('auth.mobile')->with('alert.warning','لطفا شماره تلفن همراه خود را وارد فرمایید');
        }

        $is_verified = \Session::get('is_verified');
        if (!$is_verified) {
            // todo otp
            return redirect()->route('auth.otp')->with('alert.warning','کد تایید را وارد فرمایید.');
        }
        $registerFields = config('authentication.database.registerFields');
        if (is_array($registerFields) && array_key_exists('province_and_city', $registerFields)) {
            $provinces = \DB::table('province_cities')->whereNull('parent_id')->orderBy('sort')->get();
        }

        $viewData = ['registerFields'];
        
        if (is_array($registerFields) && array_key_exists('province_and_city', $registerFields)) {
            $viewData[] = 'provinces';
        }
        
        return view('auth::auth.user_info', compact($viewData));
    }

    public function postUserInfo (UserInfoRequest $request)
    {

        $national_id = \Session::get('national_id');
        if (!$national_id) {
            return redirect()->route('auth.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
        }

        $user = \DB::table('users')->where('national_id', '=', $national_id)->first();
        if ($user) {
            return redirect()->route('auth.password');
        }

        $mobile = \Session::get('mobile');
        if (!$mobile) {
            return redirect()->route('auth.mobile')->with('alert.warning','لطفا شماره تلفن همراه خود را وارد فرمایید');
        }

        $is_verified = \Session::get('is_verified');
        if (!$is_verified) {
            // todo otp
            return redirect()->route('auth.otp')->with('alert.warning','کد تایید را وارد فرمایید.');
        }
        $registerFields = config('authentication.database.registerFields');
        if (is_array($registerFields) && array_key_exists('recommender_user_id', $registerFields))
        {
            $recoommenderUserId = null;
            if ($request->recommender_user_hash) {
                $recoommenderUser = User::where('hash',$request->recommender_user_hash)->first();
    
                if (!$recoommenderUser) {
                    return  back()->withErrors(['recommender_user_hash' => 'هیچ کاربری با این کدمعرف یافت نشد'])->withInput($request->input());
                }
    
                $recoommenderUserId = $recoommenderUser->id;
            }
        }

        $userData = [
            'national_id'        => $national_id,
            'mobile'             => $mobile,
            'mobile_verified_at' => new \DateTime('UTC'),
            'password'           => \Hash::make($request->password),
            'hash'               => $this->makeUniqueUserHash(),
        ];
        
        if (is_array($registerFields) && array_key_exists('first_name', $registerFields)) {
            $userData['first_name'] = $request->first_name;
        }
        if (is_array($registerFields) && array_key_exists('last_name', $registerFields)) {
            $userData['last_name'] = $request->last_name;
        }
        if (is_array($registerFields) && array_key_exists('gender', $registerFields)) {
            $userData['gender'] = $request->gender;
        }
        if (is_array($registerFields) && array_key_exists('province_and_city', $registerFields)) {
            $userData['province_id'] = $request->province;
            $userData['city_id'] = $request->city;
        }
        if (is_array($registerFields) && array_key_exists('school', $registerFields)) {
            $userData['school'] = $request->school_name;
        }
        if (is_array($registerFields) && array_key_exists('recommender_user_id', $registerFields)) {
            $userData['recommender_user_id'] = $recoommenderUserId;
        }
        
        $user = new User($userData);


        $this->loginUser($user);
        return  $this->findRedirectUrl($user);

    }

    public function getTrustedUserInfo () {

        $user = Auth::user();
        if (!$user) {
            $national_id = \Session::get('national_id');
            if (!$national_id) {
                return redirect()->route('auth.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
            }
            $user = User::where('national_id', '=', $national_id)->first();
            if ($user) {
                return redirect()->route('auth.password');
            }
            $mobile = \Session::get('mobile');
            if (!$mobile) {
                return redirect()->route('auth.mobile')->with('alert.warning','لطفا شماره تلفن همراه خود را وارد فرمایید');
            }
            $is_verified = \Session::get('is_verified');
            if (!$is_verified) {
                // todo otp
                return redirect()->route('auth.otp')->with('alert.warning','کد تایید را وارد فرمایید.');
            }
        }

        $provinces = \DB::table('province_cities')->whereNull('parent_id')->orderBy('sort')->get();

        $job = $degree = $personnelCard = $nationalCard = null;
        if ($user) {
            $job = UserMetaService::get($user->id,'JOB');
            $degree = UserMetaService::get($user->id,'EDUCATION_DEGREE');
            $nationalCardAttachmentId = UserMetaService::get($user->id,'NATIONAL_CARD_ATTACHMENT_ID');
            if ($nationalCardAttachmentId) {
                $nationalCard = Attachment::find($nationalCardAttachmentId);
            }

            $personnelCardAttachmentId = UserMetaService::get($user->id,'PERSONNEL_CARD_ATTACHMENT_ID');
            if ($personnelCardAttachmentId) {
                $personnelCard = Attachment::find($personnelCardAttachmentId);
            }


        }

        return view('auth.trusted_user_info',compact(
            'provinces',
            'user',
            'job','degree','personnelCard','nationalCard'
        ));
    }

    public function postTrustedUserInfo (Request $request) {

        $user = Auth::user();
        $stringFunctions = new StringFunctions();

        if (!$user) {
            $national_id = \Session::get('national_id');
            if (!$national_id) {
                return redirect()->route('auth.national_id')->with('alert.warning','لطفا کد ملی خود را وارد فرمایید');
            }
            $user = User::where('national_id', '=', $national_id)->first();
            if ($user) {
                return redirect()->route('auth.password');
            }
            $mobile = \Session::get('mobile');
            if (!$mobile) {
                return redirect()->route('auth.mobile')->with('alert.warning','لطفا شماره تلفن همراه خود را وارد فرمایید');
            }
            $is_verified = \Session::get('is_verified');
            if (!$is_verified) {
                // todo otp
                return redirect()->route('auth.otp')->with('alert.warning','کد تایید را وارد فرمایید.');
            }
        }

        $birthday = $stringFunctions->convertPersianStringDateToDatetime($request->birthday);


        $data = [];
        if (!$user) {
            $data = array_merge($data, [
                'national_id' => $national_id,
                'mobile' => $mobile,
                'mobile_verified_at' => new \DateTime('UTC'),
                'password' => \Hash::make($request->password),
                'hash' => $this->makeUniqueUserHash(),

            ]);
        }
        $data = array_merge($data, [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'province_id' => $request->province,
            'city_id' => $request->city,
            'birthday' => $birthday,
        ]);

        if ($user) {
            $user->update($data);
        }else {
            $user = User::create($data);

            $this->loginUser($user);
        }

        if ($request->file('national_card')) {
            $nationalCardAttachment = UploadController::uploadImage(
                $request->file('national_card'),
                "public/images/user/{$user->id}/documents",
            );

            $lastAttachmentId = UserMetaService::get($user->id,'PERSONNEL_CARD_ATTACHMENT_ID');
            UploadController::removeAttachment($lastAttachmentId);
            UserMetaService::update($user->id,'NATIONAL_CARD_ATTACHMENT_ID', $nationalCardAttachment->id);
        }

        if ($request->file('personnel_card')) {
            $personnelCardAttachment = UploadController::uploadImage(
                $request->file('personnel_card'),
                "public/images/user/{$user->id}/documents",
            );

            $lastAttachmentId = UserMetaService::get($user->id,'PERSONNEL_CARD_ATTACHMENT_ID');
            UploadController::removeAttachment($lastAttachmentId);
            UserMetaService::update($user->id,'PERSONNEL_CARD_ATTACHMENT_ID', $personnelCardAttachment->id);
        }

        $job = UserMetaService::update($user->id,'JOB',$request->job);
        $degree = UserMetaService::update($user->id,'EDUCATION_DEGREE', $request->education_degree);

        $trustedUser = TrustedUser::where('user_id',$user->id)->first();
        if (!$trustedUser) {
            $trustedUser = TrustedUser::create([
                'user_id' => $user->id,
            ]);
        }

        return  redirect()->route('trusted-user.tracking');

    }

    public function sendOtp ($mobile)
    {
        $nowDate = new \DateTime('UTC');
        $twoMinAgo = $nowDate->sub(new \DateInterval('PT2M'));
        $stringFunctions = new StringFunctions();

        $securityLogCount = SecurityLog::where('data','=',$mobile)
            ->where('created_at', '>', $twoMinAgo)
            ->where('type','=','SEND_OTP')
            ->first();

        if ($securityLogCount) {
            return [
                'message' => 'قبلا پیامک فعال‌سازی ارسال شده. لطفا ۲ دقیقه دیگر تلاش فرمایید.',
                'code' => -1,
                'data' => []
            ];
        }

        $otp = rand(1000,9999);
        \Session::put('otp', $otp);

        if (env('APP_ENV') != 'local') {
            $optSender = app(OtpSenderInterface::class);
            $optSender->sendOtp($mobile,['token' => $otp]);
        }

        SecurityLog::create([
            'type' => 'SEND_OTP',
            'data' => $mobile,
            'ip'   => $stringFunctions->getRealIPAddr(request()),
        ]);

        return [
            'message' => 'با موفقیت ارسال شد',
            'code' => 1,
            'data' => [
                'otp' => $otp,
            ]
        ];
    }

    public function makeUniqueUserHash ()
    {
        $hash = '';
        $find = true;
        while ($find) {
            $hash = substr(md5(random_bytes(10)),0,8);
            $find = \DB::table('users')->where('hash', '=', $hash)->first();
        }

        return $hash;
    }

    public function loginUser ($user) {

        \Auth::login($user,true);

        \Session::forget([
            'national_id',
            'mobile',
            'otp',
            'is_verified',
        ]);

        $userAgentService = new UserAgentService();
        $userAgentService->set($user);
    }

    public function findRedirectUrl ($user = null)
    {

        if (!$user) {
            return  redirect()->route('auth.user_info');
        }

        $back_url = Session::get('back_url');
        if ($back_url) {
            return redirect($back_url)->with('alert.success',$user->first_name . ' عزیز، خوش آمدید');
        }

        return redirect()->route('home')->with('alert.success',$user->first_name . ' عزیز، خوش آمدید');
    }

    public function resendOtp (Request $request)
    {
        $mobile = $request->mobile;
        if (!$mobile) {
            return response()->json([
                'message' => 'شماره تلفن همراه یافت نشد. لطفا صفحه را رفرش کنید',
                'code' => -1,
                'data' => []
            ],400);
        }

        $otpResult = $this->sendOtp($mobile);

        if ($otpResult['code'] < 1) {
            return  response()->json([
                'message' => $otpResult['message'],
                'code' => -2,
                'data' => []
            ],400);
        }
        return response()->json([
            'message' => 'با موفقیت ارسال شد',
            'code' => -1,
            'data' => []
        ]);
    }
}