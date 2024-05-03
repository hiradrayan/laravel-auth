<?php

namespace Authentication\path\rules;

use Illuminate\Contracts\Validation\Rule;

class NationalCode implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        $nationalCode = trim($value, ' .');
        $nationalCode = $this->convertArabicToEnglish($nationalCode);
        $nationalCode = $this->convertPersianToEnglish($nationalCode);
        $bannedArray = ['0000000000', '1111111111', '2222222222', '3333333333', '4444444444', '5555555555', '6666666666', '7777777777', '8888888888', '9999999999'];
    
        if(empty($nationalCode))
        {
            return false;
        }
        else if(count(str_split($nationalCode)) != 10)
        {
            return false;
        }
        else if(in_array($nationalCode, $bannedArray))
        {
            return false;
        }
        else{
    
            $sum = 0;
    
            for($i = 0; $i < 9; $i++)
            {
                // 1234567890
                $sum += (int) $nationalCode[$i] * (10 - $i);
            }
    
            $divideRemaining = $sum % 11;
    
            if($divideRemaining < 2)
            {
                $lastDigit = $divideRemaining;
            }
            else{
                $lastDigit = 11 - ($divideRemaining);
            }
    
            if((int) $nationalCode[9] == $lastDigit)
            {
                return true;
            }
            else{
                return false;
            }
    
        }
    }


    protected function convertArabicToEnglish($number)
    {
        $number = str_replace('۰', '0', $number);
        $number = str_replace('۱', '1', $number);
        $number = str_replace('۲', '2', $number);
        $number = str_replace('۳', '3', $number);
        $number = str_replace('۴', '4', $number);
        $number = str_replace('۵', '5', $number);
        $number = str_replace('۶', '6', $number);
        $number = str_replace('۷', '7', $number);
        $number = str_replace('۸', '8', $number);
        $number = str_replace('۹', '9', $number);

        return $number;
    }

    protected function convertPersianToEnglish($number)
    {
        $number = str_replace('۰', '0', $number);
        $number = str_replace('۱', '1', $number);
        $number = str_replace('۲', '2', $number);
        $number = str_replace('۳', '3', $number);
        $number = str_replace('۴', '4', $number);
        $number = str_replace('۵', '5', $number);
        $number = str_replace('۶', '6', $number);
        $number = str_replace('۷', '7', $number);
        $number = str_replace('۸', '8', $number);
        $number = str_replace('۹', '9', $number);

        return $number;
    }




    public function message()
    {
        return ':attribute معتبر نمیباشد';
    }
}
