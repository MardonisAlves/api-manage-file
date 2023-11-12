<?php

use App\Controllers\UserController;
use App\Controllers\AuthController;
use Slim\Routing\RouteCollectorProxy;
use App\Middleware\JwtMiddleware;
use App\Helpers\ValidatorUserCreate;

include_once 'dependeces.php';


$app->group('/users',  function(RouteCollectorProxy $group){
    $group->get('/findall',  function ($request, $response){
        $userController = new UserController($request, $response);
        return $userController->findAll();
    });

    $group->post('/create', function($request, $response) {
        $userController = new UserController($request, $response);
        return $userController->create();
    })->add(new ValidatorUserCreate());

});//->add(new JwtMiddleware());





$app->post('/auth', function($request, $response){
$auth = new AuthController($request, $response);
return $auth->auth();
});

$app->addErrorMiddleware(true, true, true);
$app->run();


