<?php
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use Pecee\SimpleRouter\SimpleRouter;
use App\Middleware\JwtMiddleware;


SimpleRouter::group(['middleware' => JwtMiddleware::class], function () {
    SimpleRouter::get('/',  [HomeController::class, 'home']);
});

SimpleRouter::post('/auth', [AuthController::class, 'auth']);


SimpleRouter::get('/favicon.ico', function() {
    return;
});
