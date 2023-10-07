<?php

namespace App\Controllers;
use App\Services\ServiceHome;


class HomeController {

   public function home() {
      $serviceHome = new ServiceHome();
      return $serviceHome->index();
   }
}