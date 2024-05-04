<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\GeneralRequest;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmedPasswordRequest extends GeneralRequest
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
            'password' => 'required|min:8|confirmed',
        ];
    }
}
