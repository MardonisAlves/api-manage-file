<?php
namespace App\Middleware;
use App\Utils\JwtUtil;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Helpers\Header;

class JwtMiddleware{
    public function __invoke(Request $request, $handler): Response {
        try {
           return  $this->verifyTokem($request, $handler);
        } catch (\Exception $e) {
           return Header::jwtHeaderError($e, (int)401);
        }
}

public static function verifyTokem($request, $handler){
    $token = $request->getHeaderLine('Authorization');
    if (empty($token)) {
    return Header::validateRequest((int)401, 'Token não fornecido');
    }else{
        $verify = JwtUtil::decodeJwt($token);
        if(property_exists($verify, 'exp') && $verify->permission->permission > 0) {
            return $handler->handle($request);
        }else{
           return Header::validateRequest((int)401, 'Por favor verificar suas credenciais de acesso');
        }
    }
}
}
