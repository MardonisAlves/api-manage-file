<?php
namespace App\Middleware;
use App\Utils\JwtUtil;
use App\Exceptions\UnauthorizedException;
use Firebase\JWT\JWT;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use Pecee\Http\Response;


class JwtMiddleware implements IMiddleware{

    public function handle(Request $request):void {
        $token = $request->getHeader('Authorization');

        if (!$token) {
            $response = new Response($request);
            $response->json(['error' => 'Unauthorized']);
            $response->send();
        }

        $token = str_replace('Bearer ', '', $token);
    
        try {
      
        $decode = JwtUtil::decodeJwt($token);
        $responseArray = json_decode($decode, true);
        if(isset($responseArray['error'])){
            $response = new Response($request);
             $response->json($responseArray);
             $response->send();
        }

        } catch (\Exception $e) {
            $response = new Response($request);
            $response->json(['error' => 'Unauthorized']);
            $response->send();
        }
    }
}

$request = new Request();
$response = new Response($request);

$md = new JwtMiddleware($request, $response);
$md->handle($request);


