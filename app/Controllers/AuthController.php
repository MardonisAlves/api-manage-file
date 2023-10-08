<?php
namespace App\Controllers;
use App\Utils\JwtUtil;
use App\Model\User;

class AuthController {

   public function auth(){
       $user = User::where('email', 'admin@gmail.com')->first();
       if (!$user || !password_verify('123456789', $user->password)) {
           return json_encode(['error' => 'Credenciais inválidas']);
       }
    $token = JwtUtil::generateToken(['user_id' => $user->id]);
    return json_encode(['token' => $token]);
   }

}