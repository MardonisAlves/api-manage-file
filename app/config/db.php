<?php
require_once 'config.env.php';
use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;

  $con =  [
    'driver'   => getenv('DB_CONNECTION'),
    'host'     => getenv('DB_HOST'),
    'port'     => getenv('DB_PORT'),
    'database' => getenv('DB_DATABASE'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'charset'  => 'utf8'
    ];

$capsule->addConnection($con);
$capsule->bootEloquent();
    
