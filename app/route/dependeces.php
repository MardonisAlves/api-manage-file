<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Factory\AppFactory;


$app = AppFactory::create();
$app->addRoutingMiddleware();
$container = $app->getContainer();

$dbSettings = require  'app/config/db.php';

$capsule = new Capsule;
$capsule->addConnection($dbSettings);
$capsule->setAsGlobal();
$capsule->bootEloquent();
$capsule->getConnection();



