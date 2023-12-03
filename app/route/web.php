<?php

use App\Controllers\UserController;
use App\Controllers\AuthController;
use App\Controllers\UploadFileController;
use Slim\Routing\RouteCollectorProxy;
use App\Middleware\JwtMiddleware;
use App\Helpers\ValidatorUserCreate;
use App\Dependeces\Dependeces;

$app =  Dependeces::dependeces();
/* aurh */
$app->post('/auth', function($request, $response){
    $auth = new AuthController($request, $response);
    return $auth->auth();
});

/* users */
$app->group('/users',  function(RouteCollectorProxy $group){
    $group->get('/findall',  function ($request, $response){
        $userController = new UserController($request, $response);
        return $userController->findAll();
    });
    $group->post('/create', function($request, $response) {
        $userController = new UserController($request, $response);
        return $userController->create();
    })->add(new ValidatorUserCreate());

})->add(new JwtMiddleware());


/* upload */
$app->group('/upload', function(RouteCollectorProxy $group){
    $group->post('/create', function ($request, $response){
        $createUpload = new UploadFileController($request, $response);
        return $createUpload->createUpload();
    });
    $group->delete('/delete', function ($request, $response){
        $createUpload = new UploadFileController($request, $response);
        return $createUpload->deleteUpload();
    });
    $group->get('/list', function ($request, $response){
        $createUpload = new UploadFileController($request, $response);
        return $createUpload->listUpload();
    });
    $group->post('/folder', function ($request, $response){
        $createUpload = new UploadFileController($request, $response);
        return $createUpload->createFolder();
    });
})->add(new JwtMiddleware());


$app->addErrorMiddleware(true, true, true);
$app->run();


