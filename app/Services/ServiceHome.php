<?php
namespace App\Services;
use App\Model\User;

class ServiceHome {

   public  function index() {
     try {
      $user = User::all();
      if (!$user) {
          throw new UnexpectedValueException('Nenhum usuário encontrado.');
      }

     return $user;
     } catch (\Throwable $th) {
     var_dump($th);
     }
   }
}