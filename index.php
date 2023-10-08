<?php
use App\Middleware\JwtMiddleware;
use Pecee\SimpleRouter\SimpleRouter;

require_once 'vendor/autoload.php';
require_once 'app/config/db.php';

require_once 'app/route/web.php';
SimpleRouter::start();



