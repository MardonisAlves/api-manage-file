<?php
namespace App\Middleware;
use App\Utils\JwtUtil;
use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Closure;


class JwtMiddleware{

    public function handle(ServerRequestInterface $request, Closure $next) {
        $token = $request->getHeaders();
        
        var_dump($token['authorization'][0]);
    
        if (!$token) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }
    
        // Verificar e validar o token JWT
        try {
            $decodedToken = JwtUtil::decodeJwt($token['authorization'][0]);
            return $next($decodedToken);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid token'], 401);
        }
}
}
