<?php

namespace Authentication\path\requests;

use Authentication\path\\rules\NationalCode;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nationalId' => ['required', 'max:10', new NationalCode()],
            'password'   => 'required'
        ];
    }
}