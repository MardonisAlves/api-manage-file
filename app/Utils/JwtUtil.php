<?php
namespace App\Utils;

use Firebase\JWT\JWT;

class JwtUtil {
    public static function generateToken($data) {
        return JWT::encode($data, getenv('SECRET_KEY'), 'HS256');
    }

    public static function decodeJwt(){
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoyfQ.akVwTHw6I8So4NAPVpxhn5fSDG3I6XOtsBacOVkgQVQ';
        return JWT::decode($jwt, new key(getenv('SECRET_KEY'), 'HS256'));
    }
}
