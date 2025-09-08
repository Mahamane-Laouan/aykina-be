<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Msg91Service
{
    protected $authkey;
    protected $sender;
    protected $route;
    protected $template_id;

    public function __construct()
    {
        $this->authkey = config('services.msg91.authkey');
        $this->sender = config('services.msg91.sender');
        $this->route = config('services.msg91.route');
        $this->template_id = config('services.msg91.template_id');
    }

    public function sendOtp($mobile, $otp)
{
    $url = "https://api.msg91.com/api/v5/otp";
    $payload = [
        "template_id" => $this->template_id,
        "mobile" => '91' . $mobile,  // Ensure correct country code
        "authkey" => $this->authkey,
        "sender" => $this->sender,
        "otp" => $otp,
        "route" => $this->route,
    ];

    // Log the payload
    Log::info('Sending OTP payload', $payload);

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post($url, $payload);

    $responseBody = $response->json();

    // Log the response
    Log::info('Response from MSG91', $responseBody);

    return $responseBody;
}
}
