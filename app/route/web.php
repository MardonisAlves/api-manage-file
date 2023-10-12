<?php
use App\Controllers\UserController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as Capsule;


use Slim\Factory\AppFactory;
$app = AppFactory::create();
$container = $app->getContainer();

$dbSettings = require  'app/config/db.php';



$capsule = new Capsule;
$capsule->addConnection($dbSettings);
$capsule->setAsGlobal();
$capsule->bootEloquent();
$capsule->getConnection();


$container['db'] = function () use($capsule){
    return $capsule;
};

$app->get('/', function ($request, $response) use ($container) {
    $userController = new UserController($container['db']);
    return $userController->all($request, $response);
});

$app->run();


