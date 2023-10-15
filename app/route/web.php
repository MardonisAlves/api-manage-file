<?php

use App\Controllers\UserController;
use App\Controllers\AuthController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Routing\RouteCollectorProxy;
use App\Middleware\JwtMiddleware;

include_once 'dependeces.php';



$app->group('/users', function(RouteCollectorProxy $group){
    $group->get('/findall', function ($request, $response){
        $userController = new UserController($request, $response);
        return $userController->findAll();
    })->add(new JwtMiddleware());
});

$app->post('/auth', function($request, $response) use ($container) {
$auth = new AuthController($request, $response);
return $auth->auth();
});

$app->addErrorMiddleware(true, true, true);
$app->run();


