<?php
define('CONTENT_TYPE_JSON', 'application/json');
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once 'app/route/web.php';




