<?php

use App\Http\Services\Course\CourseService;
use App\Http\Services\File\ImageFilterService;
use App\Http\Services\jDateTime;
use App\Http\Services\NumToWord_Fa;
use App\Http\Services\StringFunctions;
use App\Http\Services\User\AuthService;
use App\Models\App\Accounting;
use App\Models\App\Attachment;
use App\Models\App\PaymentRequest;
use App\Models\Course\Course;
use App\Models\Course\CourseTeacher;
use App\Models\Course\CourseWidget;
use App\Models\Tutorship\Instructor;
use App\Models\User\User;
use App\Models\User\VerifyAttachment;
use Intervention\Image\ImageManagerStatic;

function helperTest ($text) {
    return '____'.$text.'___';
}

function fa_num(string $text = null) {
    $stringFunctions = new StringFunctions();
    return $stringFunctions->convertNumbersToFarsi($text);
}

function en_num(string $text = null) {
    $stringFunctions = new StringFunctions();
    return $stringFunctions->convertNumbersToEnglish($text);
}

function j_date (DateTime $inputDate = null, string $format = "Y/m/d-H:i:s", string $timezone = "Asia/Tehran")
{
    if (!$inputDate || !is_object($inputDate)) {
        return null;
    }

    $date = new jDateTime(True, True, $timezone);
    return $date->date($format, $inputDate->getTimestamp());
}

function beauty_fa_num ($text) {
    $stringFunctions = new StringFunctions();
    return $stringFunctions->beautyFarsiNumbers($text);
}

function is_granted (string $role, User $user = null) {

    if (!$user) {
        $user = Auth::user();
    }

    if (!$user) {
        return false;
    }

    $roleHierarchy = [
        'ROLE_SUPER_ADMIN'  => ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN', 'ROLE_TEACHER', 'ROLE_USER','ROLE_INSTRUCTOR','ROLE_OPERATOR','ROLE_TRUSTED_USER'],
        'ROLE_ADMIN'        => ['ROLE_ADMIN', 'ROLE_TEACHER', 'ROLE_USER','ROLE_OPERATOR','ROLE_TRUSTED_USER'],
        'ROLE_TEACHER'      => ['ROLE_TEACHER', 'ROLE_USER'],
        'ROLE_INSTRUCTOR'   => ['ROLE_INSTRUCTOR', 'ROLE_USER'],
        'ROLE_OPERATOR'     => ['ROLE_OPERATOR', 'ROLE_USER'],
        'ROLE_TRUSTED_USER' => ['ROLE_USER','ROLE_TRUSTED_USER'],
        'ROLE_USER'         => ['ROLE_USER'],
    ];


    $userAllRoles = [];
    foreach ($user->roles as $userRole) {
        $roles = $roleHierarchy[$userRole] ?? [$userRole];
        $userAllRoles = array_merge($userAllRoles,$roles);
    }

    $userAllRoles  = array_unique($userAllRoles);

    if (!in_array ($role, $userAllRoles)) {
        return false;
    }

    return true;
}

function is_permitted (array $permission, User $user = null, Course $course = null) {
    return AuthService::is_permitted ($permission, $user, $course);
}
function is_instructor_access (Instructor $instructor = null) {
    if (is_granted("ROLE_ADMIN")) {
        return true;
    }
    if (!$instructor || !$instructor->is_active || $instructor->is_blocked) {
        abort(401);
    }


    $currentUser = Auth::user();
    if (is_granted("ROLE_INSTRUCTOR") && $instructor->user_id == $currentUser->id) {
        return  true;
    }

    abort(401);
}

function masked_mobile (string $mobile) {
    $masked =  substr( $mobile, 0, 2 ) // Get the first two digits
        .str_repeat( '*', ( strlen( $mobile ) - 6 ) ) // Apply enough asterisks to cover the middle numbers
        .substr( $mobile, - 4 ); // Get the last two digits

    return fa_num($masked);
}

function number_to_words (string $text)
{
    $numberWord = new NumToWord_Fa();
    return $numberWord->numberToWords ($text);
}

function min_to_time (string $min = null) {
    if (!$min) {
        return  null;
    }
    $stringFunctions = new StringFunctions();
    return $stringFunctions->minToTime($min);
}

function sec_to_time (string $seconds = null) {
    if (!$seconds) {
        return  null;
    }
    $stringFunctions = new StringFunctions();
    return $stringFunctions->secondToTime($seconds);
}

function mime_to_ext($mimeTypes) {
    $mimeTypes = explode(' ', $mimeTypes);
    $result = [];
    foreach ($mimeTypes as $mt) {
        $result[] = StringFunctions::mime2ext($mt);
    }
    return join(', ', $result);
}

function format_bytes($size, $precision = 2)
{
    if (!$size) {
        return '۰';
    }
    $base = log($size, 1024);
    $suffixes = array('بایت', 'کیلوبایت', 'مگابایت', 'گیگابایت', 'ترابایت');

    $stringFunctions = new stringFunctions();
    return $stringFunctions->convertNumbersToFarsi(round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)]);
}



function fa_course_type (string $type) {

    switch ($type) {
        case 'RECORDED':
            return 'ضبط شده';
        case 'WEBINAR':
            return 'وبینار';
        case 'LIVE':
            return 'لایو';
        case 'IN_PERSON':
            return 'حضوری';
        case 'BUNDLE':
            return 'باندل';

    }
}

function course_image_url (Course $course, string $filter_name = 'course_thumb') {
    $default = 'assets/img/default-course-2.png';

    if (!$course->image_id) {
        return $default;
    }

    $imageUrl = $course->image->url;

    if (!$filter_name) {
        return 'storage/'.$imageUrl;
    }

    $imageService = new ImageFilterService();
    $url = $imageService->filterImage($imageUrl, $filter_name);
    return  $url ?? $default;


}

function teacher_image_url (CourseTeacher $teacher, $filter_name = '300_300') {
    $default = 'assets/img/avatar.png';

    if (!$teacher->image_id) {
        return $default;
    }

    $imageUrl = $teacher->image->url ;

    if (!$filter_name) {
        return 'storage/'.$imageUrl;
    }

    $imageService = new ImageFilterService();
    return  $imageService->filterImage($imageUrl, $filter_name);

}

function user_image_url (User $user, $filter_name = '300_300') {
    $default = 'assets/img/avatar.png';

    if (!$user || !$user->image_id) {
        return $default;
    }

    $imageUrl = $user->image->url ;

    if (!$filter_name) {
        return 'storage/'.$imageUrl;
    }

    $imageService = new ImageFilterService();
    return  $imageService->filterImage($imageUrl, $filter_name);

}

function image_url($image_id, $filter_name = '300_300') {

    $imageUrl = Attachment::find($image_id)->url;

    if (!$filter_name) {
        return 'storage/' . $imageUrl;
    }

    $imageService = new ImageFilterService();
    return $imageService->filterImage($imageUrl, $filter_name);
}


function verify_image_url (VerifyAttachment $verify_attachement, $filter_name = '300_300') {
    $default = 'assets/img/avatar.png';

    if (!$verify_attachement) {
        return $default;
    }

    $imageUrl = $verify_attachement->attachment->url ;

    if (!$filter_name) {
        return 'storage/'.$imageUrl;
    }

    $imageService = new ImageFilterService();
    return  $imageService->filterImage($imageUrl, $filter_name);

}

function attachment_url ($attachmentId, $filterName = null) {
    $attachment = Attachment::find($attachmentId);

    if ($attachment->s3_parameters) {
        return $attachment->url;
    }

    if(is_null($filterName)) {
        return  'storage/' .$attachment->url;
    }

    $imageService = new ImageFilterService();
    return $imageService->filterImage($attachment->url, $filterName);
}


function course_score(Course $course) {
    $courseService = new CourseService();

    return $courseService->getCourseScore($course);
}

function wallet (User $user, $withPaymentRequest = true) {
    $accountingWallet = Accounting::where('user_id',$user->id)
        ->sum('price');

    $paymentRequestAmount = $withPaymentRequest ? PaymentRequest::where('user_id',$user->id)
        ->where('status',PaymentRequest::STATUS['REQUESTED'])
        ->sum('price') : 0;

    return $accountingWallet - $paymentRequestAmount;
}
