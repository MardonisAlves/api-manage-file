<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Model\User;
use App\Helpers\Header;
use App\Utils\JwtUtil;
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

      $verifyUser = JwtUtil::verifyUserEmail($post['email']);
      if(!empty($verifyUser)){
       return Header::validateRequest((int)200, 'Usuário ja esta cadastrado');
      }else{
        $create = new User;
        $create->email = $post['email'];
        $create->name = $post['name'];
        $create->password = password_hash($post['password'], PASSWORD_DEFAULT, ['cost' => 12]);
        $create->typeuser = $post['type'];
        $create->save();
        

        return Header::headerToArray($create, $this->response, (int)200,'Usuário cadastrado com sucesso');

      }
    } catch (Exception $e) {
      return Header::validateRequest((int)500, $e->getMessage());
    }
   }
}






