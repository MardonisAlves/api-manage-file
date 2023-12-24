<?php

namespace App\Config;

class Config
{
    protected static function connectionDb()
    {
        return [
            'driver' => $_ENV['PGSQL_DRIVER'],
            'host' => $_ENV['PGSQL_HOST'],
            'port' => $_ENV['PGSQL_PORT'],
            'database' => $_ENV['PGSQL_DATABASE'],
            'username' => $_ENV['PGSQL_USER'],
            'password' => $_ENV['PGSQL_PASSWORD'],
            'charset' => $_ENV['CHARSET']
        ];
    }
}
