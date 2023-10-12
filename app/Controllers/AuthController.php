<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use Psr\Http\Message\StreamInterface;
use App\Utils\JwtUtil;
use App\Model\User;

class AuthController extends BaseController{

   public function auth(){
        $data =  $this->request->getBody();
        $post = json_decode($data, true);
        $user = User::where('email', $post['email'])->first();
       
       if (!$user || !password_verify($post['passsword'], $user->password)) {
           return json_encode(['error' => 'Credenciais inválidas']);
       }
    return JwtUtil::generateToken(['user_id' => $user->id]);
   
   }

}
