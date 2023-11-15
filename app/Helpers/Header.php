<?php

namespace App\Helpers;
use App\Helpers\AbstractLogger;
class Header{

    public static function headerToArray($data, $response, $status, $message){
        $usersArray = $data->toArray();
        $response->getBody()->write(json_encode(['data' => $usersArray, 'message' => $message]));
        return $response->withHeader('Content-Type', CONTENT_TYPE_JSON)->withStatus((int)$status);
    }
    
    public static function jwtHeaderError($e, $status){
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode([
            'error' => $e->getMessage(),
            'message' => 'tokem invalido',
            'status' => (int)$status
        ]));
        AbstractLogger::info($e, $status);
        return $response->withHeader('Content-Type', CONTENT_TYPE_JSON)->withStatus((int)$status);
    }

    public static function jwtHeader($status, $jwt){
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode([
            'message' => 'auth success',
            'status' => (int)$status,
            'tokem' => $jwt
        ]));
        return $response->withHeader('Content-Type', CONTENT_TYPE_JSON)->withStatus((int)$status);
    }

    public static function validateUser($err, $status){
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode([
            'message' => 'Campos obrigatorios',
            'status' => (int)$status,
            'error' => $err
        ]));
        return $response->withHeader('Content-Type', CONTENT_TYPE_JSON)->withStatus((int)$status);
    }

    public static function validateRequest($status, $msg){
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode([
            'message'=> $msg,
            'status'=> (int)$status,
        ]));
    return $response->withHeader('Content-Type', CONTENT_TYPE_JSON)->withStatus((int)$status);

                
    }
}
