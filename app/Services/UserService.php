<?php
namespace App\Services;
use App\Model\User;

class UserService {

   public  function index() {
     try {
      $user = User::with('Endress')->get();
      if (!$user) {
          throw new UnexpectedValueException('Nenhum usuário encontrado.');
      }

     return $user;
     } catch (\Throwable $th) {
     var_dump($th);
     }
   }
}