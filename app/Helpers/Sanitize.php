<?php

namespace App\Helpers;

class Sanitize{
    public static function strinGsanitize(string $string): string{
        return  filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
    }
}
