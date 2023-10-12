<?php
namespace App\Utils;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtUtil {
    public static function generateToken($data) {
        return JWT::encode($data, getenv('SECRET_KEY'), 'HS256');
    }

    public static function decodeJwt($jwt){
       try {
        $key = new Key(getenv('SECRET_KEY'), 'HS256');
        JWT::decode($jwt, $key);

    } catch (\Exception $e) {
        return json_encode([
            'error' => $e->getMessage(),
            'code' => 401,
            'message' => 'Unauthorized'
            ]
        );
       }
    }
}
