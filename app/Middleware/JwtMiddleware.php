<?php
namespace App\Middleware;
use App\Utils\JwtUtil;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Helpers\Header;

class JwtMiddleware{
    public function __invoke(Request $request, $handler): Response {
       
        try {
           return $this->verifyTokem($request, $handler);
        } catch (\Exception $e) {
           return Header::jwtHeaderError($e, (int)401);
        }
        
}

public static function verifyTokem($request, $handler){
    $token = $request->getHeaderLine('Authorization');
    if (empty($token)) {
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode(['error' => 'Token não fornecido']));
       return $response->withHeader('Content-Type', 'application/json')->withStatus((int)401);
     
    }else{
        $verify = JwtUtil::decodeJwt($token);
        if(property_exists($verify, 'iat')){
            return $handler->handle($request);
        }else{
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(json_encode(['error' => 'Token não fornecido']));
           return $response->withHeader('Content-Type', 'application/json')->withStatus((int)401);
        }
    }
}
}
