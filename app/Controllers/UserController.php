<?php
namespace App\Controllers;
use App\Services\UserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Model\User;

 class UserController {

  protected $db;

  public function __construct($db)
  {
      $this->db = $db;
  }

   public function all(Request $request, Response $response) {
     
     try {
      $users = User::with('Endress')->get();
      $usersArray = $users->toArray();
      $response->getBody()->write(json_encode(['users' => $usersArray]));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

     } catch (\UnexpectedValueException $e) {
      return $response->withStatus(404)->withJson(['error' => $e->getMessage()]);
     }
   }
}






