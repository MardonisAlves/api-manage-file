<?php

namespace App\Helpers;
define('CONTENT_TYPE_JSON', 'application/json');
class Header{

    public static function headerToArray($data, $response, $status){
        $usersArray = $data->toArray();
        $response->getBody()->write(json_encode(['data' => $usersArray]));
        return $response->withHeader('Content-Type', CONTENT_TYPE_JSON)->withStatus($status);
    }
    
    public static function jwtHeaderError($e, $status){
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode([
            'error' => $e->getMessage(),
            'message' => 'tokem invalido',
            'status' => $status
        ]));
        return $response->withHeader('Content-Type', CONTENT_TYPE_JSON)->withStatus($status);
    }

    public static function jwtHeader($status, $jwt){
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode([
            'message' => 'auth success',
            'status' => $status,
            'tokem' => $jwt
        ]));
        return $response->withHeader('Content-Type', CONTENT_TYPE_JSON)->withStatus($status);
    }
}
