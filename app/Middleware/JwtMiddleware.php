<?php
namespace App\Middleware;
use App\Utils\JwtUtil;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
use App\Helpers\Header;

class JwtMiddleware{
    public function __invoke(Request $request, $handler): Response {
       
        try {
            $token = $request->getHeaderLine('Authorization');
           
            if (empty($token)) {
                $response = new \Slim\Psr7\Response();
                $response->getBody()->write(json_encode(['error' => 'Token não fornecido']));
               return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }else{
                $verify = JwtUtil::decodeJwt($token);
                if(property_exists($verify, 'status')){
                   return $verify;
                }
            }
            
            return $handler->handle($request);
        } catch (\Exception $e) {
           return Header::jwtHeaderError($e, 401);
        }
        
}
}
