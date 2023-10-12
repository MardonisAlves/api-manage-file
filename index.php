<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors','On');

session_cache_limiter(false);
@session_start();

require_once 'vendor/autoload.php';


require_once 'app/route/web.php';




