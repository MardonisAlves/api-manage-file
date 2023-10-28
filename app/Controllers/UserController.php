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
       return Header::validateRequest(204, 'Usuário nao encontrado');
      } else {
      return Header::headerToArray($users, $this->response, 200);

      }

     } catch (\UnexpectedValueException $e) {
      return Header::validateRequest(500, 'Error inreno no servidor');
     }
        
   }

   public function create(){

    try {
      $data =  $this->request->getBody();
      $post = json_decode($data, true);

      $verifyUser = JwtUtil::verifyUserEmail($post['email']);

      if(!empty($verifyUser)){
       return Header::validateRequest(200, 'Usuário ja esta cadastrado');
      }else{
        $create = new User;
        $create->email = $post['email'];
        $create->name = $post['name'];
        $create->password = $post['password'];
        $create->typeuser = $post['type'];
        $create->save();
        $this->response->getBody()->write(json_encode(['data' => $post]));
        return $this->response->withHeader('Content-Type', 'application/json')->withStatus(200);

      }
    } catch (Exception $e) {
      return Header::validateRequest(500, 'Error inreno no servidor');
    }
   }
}






