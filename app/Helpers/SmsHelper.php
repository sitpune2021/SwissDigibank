<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsHelper
{
    public static function sendSms($mobile, $message)
    {
        try {
            $url = env('VOICENSMS_URL', 'https://api.voicensms.in/SMSAPI/webresources/CreateSMSCampaignPost');

            $payload = [
                "filetype"    => 2,
                "msisdn"      => [$mobile],
                "language"    => 0,
                "credittype"  => 7,
                "senderid"    => env('VOICENSMS_SENDERID', 'SBCGLB'),
                "templateid"  => 0,
                "message"     => $message,
                "ukey"        => env('VOICENSMS_UKEY', '8ZSyxFHP9LOCSZZUotdWMdzoK'),
                "isrefno"     => true,
            ];

            // $response = \Illuminate\Support\Facades\Http::asJson()->post($url, $payload);

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ])->post($url, $payload);

            Log::info('VoiceNSMS API Response', [
                'mobile' => $mobile,
                'response' => $response->json()
            ]);


            Log::info('VoiceNSMS API Response', [
                'mobile' => $mobile,
                'response' => $response->json()
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('SMS Sending Failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
