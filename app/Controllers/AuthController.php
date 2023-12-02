<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Helpers\Header;
use Exception;
use App\Utils\JwtUtil;
use App\Model\User;

class AuthController extends BaseController{

   public function auth(){
        try {
         $data =  $this->request->getBody();
         $post = json_decode($data, true);
         $user = User::with('permission')->where('email', $post['email'])->first();
         $verify = password_verify($post['password'], $user->password);

         if(empty($user) || $verify === false){
            return Header::validateRequest((int)401, 'Por favor verificar suas credenciais de acesso');
         }else{
            return JwtUtil::generateToken($user->id, $user->Permission);
         }
        } catch (Exception $e) {
         return Header::validateRequest((int)500, $e->getMessage());
        }
   
   }

}
