<?php

namespace Authentication\path\nationalId\Requests\Auth;

use Authentication\path\nationalId\Requests\GeneralRequest;
use Illuminate\Validation\Factory;

class NationalIdRequest extends GeneralRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'national_id' => 'required|max:10|national_id'
        ];
    }
}
