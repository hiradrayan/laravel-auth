<?php

namespace Authentication\path\nationalId\Requests;

use Authentication\path\Service\StringFunctions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory;

class GeneralRequest extends FormRequest
{

    public function __construct(Factory $validationFactory)
    {
        $validationFactory->extend(
            'national_id',
            function ($attribute, $value, $parameters) {
                $stringFunctions = new StringFunctions();
                return $stringFunctions->validateNationalId($value);
            },
            'کدملی وارد شده نامعتبر است.'
        );

        $validationFactory->extend(
            'mobile',
            function ($attribute, $value, $parameters) {

                if (!$value) {
                    return  true;
                }
                $stringFunctions = new StringFunctions();
                return $stringFunctions->getMobile($value);
            },
            'شماره تلفن همراه وارد شده نامعتبر است.'
        );
    }

}
