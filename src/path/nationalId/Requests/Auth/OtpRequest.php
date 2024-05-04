<?php

namespace Authentication\path\nationalId\Requests\Auth;

use Authentication\path\nationalId\Requests\GeneralRequest;
use Illuminate\Foundation\Http\FormRequest;

class OtpRequest extends GeneralRequest
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
            'otp' => 'max:4|required'
        ];
    }
}
