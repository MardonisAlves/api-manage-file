<?php

namespace App\Config;

class Config
{
    protected static function connectionDb()
    {
        return [
            'driver' => $_ENV['MYSQL_DRIVER'],
            'host' => $_ENV['MYSQL_HOST'],
            'port' => $_ENV['MYSQL_PORT'],
            'database' => $_ENV['MYSQL_DATABASE'],
            'username' => $_ENV['MYSQL_USER'],
            'password' => $_ENV['MYSQL_PASSWORD']
        ];
    }
}
