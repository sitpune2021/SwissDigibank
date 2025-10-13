<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsHelper
{
    public static function sendSms($mobile, $message)
    {
        // $mobile = '7020672418';
        try {

            $url = "https://api.voicensms.in/SMSAPI/webresources/CreateSMSCampaignPost";

            $data = [
                "filetype"    => 2,
                "msisdn"      => [$mobile],
                "language"    => 0,
                "credittype"  => 7,
                "senderid"    => "SBCGLB",
                "templateid"  => 0,
                "message"     => $message,
                "ukey"        => "8ZSyxFHP9LOCSZZUotdWMdzoK",
                "isrefno"     => true
            ];

            $ch = curl_init($url);

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_HTTPHEADER     => [
                    "Content-Type: application/json"
                ],
                CURLOPT_POSTFIELDS     => json_encode($data),
            ]);

            $response = curl_exec($ch);

            return $response;

            if (curl_errno($ch)) {
                Log::error('SMS Sending Failed - cURL Error', ['error' => curl_error($ch)]);
                return false;
            }
            curl_close($ch);
        } catch (\Exception $e) {
            Log::error('SMS Sending Failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
