<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Psr\Container\ContainerInterface;
use App\Services\UserService;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Model\User;
use App\Helpers\Header;

 class UserController extends BaseController{
   public function findAll() {
     try {
      $users = User::with('Endress')->get();
      return Header::headerToArray($users, $this->response, 200);

     } catch (\UnexpectedValueException $e) {
      return $this->response->withStatus(404)->withJson(['error' => $e->getMessage()]);
     }
        
   }

   public function create(){

    try {
      $data =  $this->request->getBody();
      $post = json_decode($data, true);

      $create = new User;
      $create->email = $post['email'];
      $create->name = $post['name'];
      $create->password = $post['password'];
      $create->typeuser = $post['type'];
      $create->save();
      
     
      $this->response->getBody()->write(json_encode(['data' => $post]));
      return $this->response->withHeader('Content-Type', 'application/json')->withStatus(200);
      
    } catch (Exception $e) {
      var_export('oi');
      return $this->response->withStatus(500)->withJson(['error' => $e->getMessage()]);
    }
   }
}






