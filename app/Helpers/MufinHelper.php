<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class MufinHelper
{


    public static function flattenArray($array, $prefix = '')
    {
        $result = [];

        foreach ($array as $key => $value) {

            if ($key === null || $key === '') continue;

            $newKey = $prefix ? $prefix . '.' . $key : $key;

            if (is_array($value)) {

                if (array_is_list($value)) {

                    foreach ($value as $index => $item) {

                        if (is_array($item)) {
                            $result = array_merge(
                                $result,
                                self::flattenArray($item, $newKey . "[$index]")
                            );
                        } else {

                            $cleanValue = self::cleanValue($item);

                            if ($cleanValue !== null) {
                                $result[$newKey . "[$index]"] = $cleanValue;
                            }
                        }
                    }
                } else {

                    $result = array_merge(
                        $result,
                        self::flattenArray($value, $newKey)
                    );
                }
            } else {

                $cleanValue = self::cleanValue($value);

                if ($cleanValue !== null) {
                    $result[$newKey] = $cleanValue;
                }
            }
        }

        return $result;
    }

    private static function cleanValue($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Convert boolean
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        // Convert to string
        $value = (string) $value;

        // Trim + remove extra spaces
        $value = trim($value);
        $value = preg_replace('/\s+/', ' ', $value);

        return $value;
    }

    public static function generateXVerify($payload)
    {
        ksort($payload);

        $string = '';
        foreach ($payload as $key => $value) {
            $string .= $key . '=' . $value . '~';
        }

        $string = rtrim($string, '~');

        $saltKey = env('MUFFINPAY_SALT_KEY');

        // ✅ IMPORTANT LINE
        $finalString = $string . $saltKey;

        Log::info('FINAL HASH STRING', ['string' => $finalString]);

        return hash('sha256', $finalString);
    }

    public static function generatePanHash($payload)
    {
        $salt = env('MUFFINPAY_SALT_KEY');

        $userId = trim($payload['userId']);
        $panNumber = strtoupper(trim($payload['pan']['number']));
        $dob = trim($payload['pan']['dob']);
        $name = strtoupper(preg_replace('/\s+/', ' ', trim($payload['pan']['name'])));

        // ✅ CORRECT FORMAT (VERY IMPORTANT)
        $string =
            "idType=" . $payload['idType'] . "~" .
            "userId=" . $userId . "~" .
            "pan.number=" . $panNumber . "~" .
            "pan.dob=" . $dob . "~" .
            "pan.name=" . $name;

        $finalString = $string . "~" . $salt;

        Log::info('FINAL HASH STRING (PAN FINAL FIXED)', [
            'string' => $finalString
        ]);

        return strtoupper(hash('sha256', $finalString));
    }

    public static function generateAadhaarHash($payload)
    {
        $salt = env('MUFFINPAY_SALT_KEY');

        $userId = trim($payload['userId']);
        $aadhaar = trim($payload['aadhar']['aadharNumber']);

        // ✅ EXACT FORMAT (PAN jaisa nahi hai)
        $string =
            "idType=" . $payload['idType'] . "~" .
            "userId=" . $userId . "~" .
            "aadhar=aadharNumber=" . $aadhaar;

        $finalString = $string . $salt;

        Log::info('FINAL HASH STRING (AADHAAR FINAL)', [
            'string' => $finalString
        ]);

        return strtoupper(hash('sha256', $finalString));
    }



}
