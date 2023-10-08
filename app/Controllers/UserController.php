<?php
namespace App\Controllers;
use App\Services\UserService;


class UserController {

   public function home() {
      $userService = new UserService();
      return $userService->index();
   }
}