<?php

return [
    'authentication' => 'national_id', // field mobile and national id is created
    'registration' => true,
    
    'database' => [
        'registerFields' => [
            'first_name'        => true,
            'last_name'         => true,
            'gender'            => false,
            'email'             => false,
            'province_and_city' => true,
            // 'school'              => true,
            // 'recommender_user_id' => false,
        ]
    ],

    'otp_sender' => App\Http\Services\Sms\OtpSender::class,

    'logo_url' => 'assets/img/bamdad-logo.png'

];