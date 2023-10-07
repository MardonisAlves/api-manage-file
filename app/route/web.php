<?php
use App\Controllers\HomeController;

use Pecee\SimpleRouter\SimpleRouter;


SimpleRouter::get('/', [HomeController::class, 'home']);

SimpleRouter::get('/about', function() {
    echo 'Esta é a página "Sobre nós".';
});

SimpleRouter::get('/favicon.ico', function() {
    return;
});
