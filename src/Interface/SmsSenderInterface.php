<?php

namespace Authentication\Interface;

interface OtpSenderInterface
{
    public function sendOtp(string $mobile, array $tokens);
}