<?php
use App\Controllers\UserController;
use App\Controllers\AuthController;
use Pecee\SimpleRouter\SimpleRouter;
use App\Middleware\JwtMiddleware;


SimpleRouter::group(['users' => JwtMiddleware::class], function () {
    SimpleRouter::get('/',  [UserController::class, 'home']);
});


SimpleRouter::post('/auth', [AuthController::class, 'auth']);


SimpleRouter::get('/debug', function(){

    phpinfo();

});


SimpleRouter::get('/favicon.ico', function() {
    return;
});
