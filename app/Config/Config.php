<?php
namespace App\Config;

class Config
{
        protected static function connectionDb()
        {
                return [

                        'driver' => $_ENV['DRIVER'],
                        'host' => $_ENV['HOST'],
                        'port' => $_ENV['PORT'],
                        'database' => $_ENV['DATABASE'],
                        'username' => $_ENV['USERNAME'],
                        'password' => '',
                        'charset' => $_ENV['CHARSET']
                ];

        }
}

