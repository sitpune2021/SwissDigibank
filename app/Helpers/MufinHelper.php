<?php

namespace App\Helpers;

class MufinHelper
{
    public static function flattenArray($array, $prefix = '')
    {
        $result = [];

        foreach ($array as $key => $value) {

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

                            if ($item !== null && $item !== '') {
                                $result[$newKey . "[$index]"] = $item;
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

                if ($value !== null && $value !== '') {
                    $result[$newKey] = $value;
                }
            }
        }

        return $result;
    }


    public static function generateXVerify($payload, $salt)
    {

        $flat = self::flattenArray($payload);

        ksort($flat);

        $pairs = [];

        foreach ($flat as $key => $value) {
            $pairs[] = $key . '=' . $value;
        }

        $string = implode('~', $pairs) . $salt;

        return strtoupper(hash('sha256', $string));
    }
}
