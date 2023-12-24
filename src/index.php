<?php
use App\Config\Config;
use App\Dependeces\Dependeces;
use App\Route\AppRoutes;
define('CONTENT_TYPE_JSON', 'application/json');
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$app = new Dependeces();
$app->dependeces();
$routes = new AppRoutes();


