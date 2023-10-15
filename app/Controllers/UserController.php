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
}






