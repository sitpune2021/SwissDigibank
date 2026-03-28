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
        $salt = env('MUFFINPAY_SALT_KEY');

        // 1. Flatten
        $flat = self::flattenArray($payload);

        // 2. Sort keys
        ksort($flat);

        // 3. Build string
        $pairs = [];
        foreach ($flat as $key => $value) {
            $pairs[] = $key . '=' . $value;
        }

        $string = implode('~', $pairs) . $salt;

        Log::info('HASH STRING', ['string' => $string]);

        // 4. Hash
        return strtoupper(hash('sha256', $string));
    }
}
