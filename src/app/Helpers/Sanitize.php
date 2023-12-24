<?php

namespace App\Helpers;

class Sanitize{
    public static function stringSanitize(string $string): string{
        return  filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public static function emailSanitize(string $string): string{
        return  filter_var($string, FILTER_SANITIZE_EMAIL);
    }
}
