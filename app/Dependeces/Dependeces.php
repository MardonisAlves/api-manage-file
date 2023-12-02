<?php
namespace App\Dependeces;
use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Factory\AppFactory;
use App\Config\Config;

class Dependeces extends Config{
    public static  function dependeces(){
        $app = AppFactory::create();
        $app->addRoutingMiddleware();
      
        $capsule = new Capsule;
        $capsule->addConnection(Config::connectionDb());
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $capsule->getConnection();
        return $app;
    }
}



