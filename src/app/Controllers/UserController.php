<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Model\User;
use App\Helpers\Header;
use App\Utils\JwtUtil;
use App\Helpers\Sanitize;
use Exception;

 class UserController extends BaseController{
   public function findAll() {
     try {
      $users = User::with('Endress')->get();
      if($users->isEmpty()) {
       return Header::validateRequest((int)204, 'Usuário nao encontrado');
      } else {
      return Header::headerToArray($users, $this->response, (int)200, 'Usuários');

      }

     } catch (\UnexpectedValueException $e) {
      return Header::validateRequest((int)500, 'Error inreno no servidor');
     }
        
   }

   public function create(){
    try {
      $data =  $this->request->getBody();
      $post = json_decode($data, true);
      $email = Sanitize::emailSanitize($post['email']);
      $verifyUser = JwtUtil::verifyUserEmail($email);
      if(!empty($verifyUser)){
       return Header::validateRequest((int)200, 'Usuário ja esta cadastrado');
      }else{
        $passWordHash = Sanitize::stringSanitize($post['password']);
        $create = new User;
        $create->email = Sanitize::emailSanitize($post['email']);
        $create->name = Sanitize::stringSanitize($post['name']);
        $create->password = password_hash($passWordHash, PASSWORD_DEFAULT, ['cost' => 12]);
        $create->typeuser = Sanitize::stringSanitize($post['type']);
        $create->save();
        return Header::headerToArray($create, $this->response, (int)200,'Usuário cadastrado com sucesso');
      }
    } catch (Exception $e) {
      return Header::validateRequest((int)500, $e->getMessage());
    }
   }
}







