<?php

namespace Authentication\path\nationalId\Requests\Auth;

use Authentication\path\nationalId\Requests\GeneralRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends GeneralRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $registerFields = config('authentication.database.registerFields');

        $requiredFields = [];
        if ($registerFields['first_name']) {
            $requiredFields['first_name'] = 'required';
        }
        if ($registerFields['last_name']) {
            $requiredFields['last_name'] = 'required';
        }
        if ($registerFields['gender']) {
            $requiredFields['gender'] = 'required';
        }
        if ($registerFields['province_and_city']) {
            $requiredFields['province'] = 'required';
            $requiredFields['city'] = 'required';
        }
        $requiredFields['password'] = 'required|min:8';
        $requiredFields['mobile'] = 'mobile';
        
        return $requiredFields;
    }
}
