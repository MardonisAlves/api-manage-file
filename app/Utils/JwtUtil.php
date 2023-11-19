<?php
namespace App\Utils;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Helpers\Header;
use App\Model\User;
use Exception;

class JwtUtil {
    public static function generateToken($data) {

        $payload = [
            'iat' => $data,
            'nbf' => 1357000000,
            "exp" => time() + (60 *60*24),
        ];
        
        $jwt = JWT::encode($payload, $_ENV['SECRET_KEY'], 'HS256');
        return Header::jwtHeader(200, $jwt);
    }

    public static function decodeJwt($jwt){
       try {
    
        $key = new Key($_ENV['SECRET_KEY'], 'HS256');
        return JWT::decode($jwt, $key);

    } catch (Exception $e) {
        return Header::jwtHeader($e->getMessage(), 401);
       }
    }

    public static function verifyUserEmail($email){
        try {
            return User::where('email', $email)->first();
           
        } catch (Exception $e) {
            return $e;
        }
    }
}
