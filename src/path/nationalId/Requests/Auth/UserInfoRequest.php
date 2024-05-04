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
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'province' => 'required',
            'city' => 'required',
            'password' => 'required|min:8',
            'grade' => 'required',
            'major' => 'required_if:grade,10,11,12',
            'mobile' => 'mobile'
        ];
    }
}
