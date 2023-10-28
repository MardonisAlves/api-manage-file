<?php

namespace App\Helpers;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


abstract class AbstractLogger{

    public static function info($e, $status){
        $log = new Logger('my_logger');
        $log->pushHandler(new StreamHandler(__DIR__.'/logs/app.log', Level::Warning));
        $log->error('error',['error' => $e->getMessage(), 'status' => $status]);
    }
}