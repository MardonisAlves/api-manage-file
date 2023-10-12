<?php
use App\Controllers\UserController;
use App\Controllers\AuthController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Routing\RouteCollectorProxy;
use App\Middleware\JwtMiddleware;
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



$app->group('/users', function(RouteCollectorProxy $group) use ($container){
    $group->get('/all', function ($request, $response) use ($container) {
        $userController = new UserController($container['db'], $request, $response);
        return $userController->all();
    })->add(new JwtMiddleware());
});

$app->post('/auth', function($request, $response) use ($container) {
$auth = new AuthController($container['db'], $request, $response);
return $auth->auth();
});

$app->run();


