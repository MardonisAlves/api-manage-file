<?php

namespace App\Helpers;
use App\Helpers\AbstractLogger;

define('CONTENT_TYPE_JSON', 'application/json');
class Header{

    public static function headerToArray($data, $response, $status, $message){
        $usersArray = $data->toArray();
        $response->getBody()->write(json_encode(['data' => $usersArray, 'message' => $message]));
        AbstractLogger::message($message, $status);
        return $response->withHeader('Content-Type', CONTENT_TYPE_JSON)->withStatus($status);
    }
    
    public static function jwtHeaderError($e, $status){
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode([
            'error' => $e->getMessage(),
            'message' => 'tokem invalido',
            'status' => $status
        ]));
        AbstractLogger::info($e, $status);
        return $response->withHeader('Content-Type', CONTENT_TYPE_JSON)->withStatus($status);
    }

    public static function jwtHeader($status, $jwt){
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode([
            'message' => 'auth success',
            'status' => $status,
            'tokem' => $jwt
        ]));
        AbstractLogger::message('Jwt created success', $status);
        return $response->withHeader('Content-Type', CONTENT_TYPE_JSON)->withStatus($status);
    }

    public static function validateUser($err, $status){
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode([
            'message' => 'Campos obrigatorios',
            'status' => $status,
            'error' => $err
        ]));
       
        return $response->withHeader('Content-Type', CONTENT_TYPE_JSON)->withStatus($status);
    }

    public static function validateRequest($status, $msg){
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode([
            'message'=> $msg,
            'status'=> $status,
        ]));
    AbstractLogger::message($msg, $status);
    return $response->withHeader('Content-Type', CONTENT_TYPE_JSON)->withStatus($status);
    }
}
