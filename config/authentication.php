<?php

return [
    'authentication' => 'national_id', // field mobile and national id is created
    
    'database' => [
        'national_id' => [
            'registerFields' => [
                'email',
                'prefix_name',
                'first_name',
                'last_name',
                'gender'
            ]
        ]
    ],

    'otp_sender' => App\Http\Services\Notification\OtpSender::class,

    'logo_url' => 'assets/img/bamdad-logo.png'

];